<?php

declare(strict_types=1);

namespace Thomas\Shared\Infrastructure;

use Aws\DynamoDb\Exception\DynamoDbException;
use Broadway\Domain\DateTime;
use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;
use Broadway\EventStore\EventStore;
use Thomas\Shared\Domain\Event;
use Thomas\Shared\Infrastructure\Exceptions\DuplicatePlayhead;
use Thomas\Shared\Infrastructure\Exceptions\EventStreamNotFound;

use function Safe\json_decode;

final class DynamoDbEventStore extends InteractsWithDynamoDb implements EventStore
{
    /**
     * @throws EventStreamNotFound
     */
    public function load($id): DomainEventStream
    {
        return $this->loadFromPlayhead($id, 0);
    }

    /**
     * @throws EventStreamNotFound
     */
    public function loadFromPlayhead($id, int $playhead): DomainEventStream
    {
        $params = [
            'TableName'                => $this->tableName,
            'Limit'                    => 100,
            'KeyConditionExpression'   => '#StreamId = :id AND #StreamVersion >= :version',
            'ExpressionAttributeNames' => [
                '#StreamId'      => 'StreamId',
                '#StreamVersion' => 'StreamVersion',
            ],
            'ExpressionAttributeValues' => [
                ':id' => [
                    'S' => $id,
                ],
                ':version' => [
                    'N' => $playhead,
                ],
            ],
        ];

        $items = $this->getItemsRecursively($params);

        if (!count($items)) {
            throw EventStreamNotFound::withAggregate((string) $id);
        }

        return new DomainEventStream(
            array_map(
                fn ($event) => $this->eventStoreToDomainMessage((array) $this->marshaler->unmarshalItem($event)),
                $items
            )
        );
    }

    public function append($id, DomainEventStream $eventStream): void
    {
        array_map(function (array $event) use ($eventStream) {
            try {
                $this->db->putItem([
                    'ConditionExpression' => 'attribute_not_exists(StreamId) AND attribute_not_exists(StreamVersion)',
                    'Item'                => $this->marshaler->marshalItem($event),
                    'TableName'           => $this->tableName,
                ]);
            } catch (DynamoDbException $e) {
                if ($e->getAwsErrorCode() === 'ConditionalCheckFailedException') {
                    throw DuplicatePlayhead::withEventStream($eventStream);
                }

                throw $e;
            }
        }, $this->domainEventStreamToArray($id, $eventStream));
    }

    private function domainEventToArray(mixed $id, DomainMessage $event): array
    {
        /** @var Event $eventData */
        $eventData = $event->getPayload();

        return [
            'StreamId'      => $id,
            'StreamVersion' => $event->getPlayhead(),
            'EventName'     => $eventData::class,
            'EventData'     => json_encode($eventData, JSON_THROW_ON_ERROR),
            'MetaData'      => json_encode($event->getMetadata()->serialize(), JSON_THROW_ON_ERROR),
            'StoredAt'      => $event->getRecordedOn()->toString(),
        ];
    }

    private function domainEventStreamToArray(mixed $id, DomainEventStream $eventStream): array
    {
        return array_map(
            fn (DomainMessage $event) => $this->domainEventToArray($id, $event),
            $eventStream->getIterator()->getArrayCopy(),
        );
    }

    private function eventStoreToDomainMessage(array $event): DomainMessage
    {
        /** @var array $metaData */
        $metaData = json_decode($event['MetaData'], true);

        return new DomainMessage(
            $event['StreamId'],
            $event['StreamVersion'],
            new Metadata($metaData),
            call_user_func([$event['EventName'], 'deserialize'], $event['EventData']),
            DateTime::fromString($event['StoredAt']),
        );
    }
}
