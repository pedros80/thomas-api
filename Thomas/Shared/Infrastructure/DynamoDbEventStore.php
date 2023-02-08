<?php

declare(strict_types=1);

namespace Thomas\Shared\Infrastructure;

use Aws\DynamoDb\Exception\DynamoDbException;
use Broadway\Domain\DateTime;
use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;
use Broadway\EventStore\EventStore;
use Thomas\Shared\Infrastructure\Exceptions\DuplicatePlayhead;
use Thomas\Shared\Infrastructure\Exceptions\EventStreamNotFound;

final class DynamoDbEventStore extends InteractsWithDynamoDb implements EventStore
{
    public function load($id): DomainEventStream
    {
        return $this->loadFromPlayhead($id, 0);
    }

    public function loadFromPlayhead($id, int $playhead): DomainEventStream
    {
        $params = [
            'TableName' => $this->tableName,
            'Limit' => 100,
            'KeyConditionExpression' => '#StreamId = :id AND #StreamVersion >= :version',
            'ExpressionAttributeNames' => [
                '#StreamId'      => 'StreamId',
                '#StreamVersion' => 'StreamVersion',
            ],
            'ExpressionAttributeValues' => [
                ':id' => [
                    'S' => (string) $id
                ],
                ':version' => [
                    'N' => $playhead
                ],
            ]
        ];

        $items = $this->getItemsRecursively($params);

        if (!count($items)) {
            throw EventStreamNotFound::withAggregate((string) $id);
        }

        return new DomainEventStream(
            array_map(
                function ($event) {
                    return $this->eventStoreToDomainMessage((array) $this->marshaler->unmarshalItem($event));
                },
                $items
            )
        );
    }

    public function append($id, DomainEventStream $eventStream): void
    {
        array_map(function ($event) use ($eventStream) {
            try {
                $this->db->putItem([
                    'ConditionExpression' => 'attribute_not_exists(StreamId) AND attribute_not_exists(StreamVersion)',
                    'Item'      => $this->marshaler->marshalItem($event),
                    'TableName' => $this->tableName,
                ]);
            } catch (DynamoDbException $e) {
                if ($e->getAwsErrorCode() === 'ConditionalCheckFailedException') {
                    throw DuplicatePlayhead::withEventStream($eventStream);
                }

                throw $e;
            }
        }, $this->domainEventStreamToArray($id, $eventStream));
    }

    private function domainEventStreamToArray(mixed $id, DomainEventStream $eventStream): array
    {
        return array_map(function ($event) use ($id) {
            $eventData = $event->getPayload();

            return [
                'StreamId'      => $id,
                'StreamVersion' => $event->getPlayhead(),
                'EventName'     => get_class($eventData),
                'EventData'     => json_encode($eventData),
                'MetaData'      => json_encode($event->getMetadata()->serialize()),
                'StoredAt'      => $event->getRecordedOn()->toString()
            ];
        }, $eventStream->getIterator()->getArrayCopy());
    }

    private function eventStoreToDomainMessage(array $event): DomainMessage
    {
        return new DomainMessage(
            $event['StreamId'],
            $event['StreamVersion'],
            new Metadata(json_decode($event['MetaData'], true)),
            call_user_func([$event['EventName'], 'deserialize'], $event['EventData']),
            DateTime::fromString($event['StoredAt'])
        );
    }
}
