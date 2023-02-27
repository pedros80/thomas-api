<?php

declare(strict_types=1);

namespace Thomas\Stations\Infrastructure\Queries;

use Pedros80\NREphp\Params\StationCode;
use Thomas\Shared\Infrastructure\InteractsWithDynamoDb;
use Thomas\Stations\Application\Queries\GetStationMessages;
use Thomas\Stations\Domain\Code;
use Thomas\Stations\Domain\Message;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageID;
use Thomas\Stations\Domain\MessageSeverity;
use Thomas\Stations\Domain\Name;
use Thomas\Stations\Domain\Station;

final class DynamoDbGetStationMessages extends InteractsWithDynamoDb implements GetStationMessages
{
    public function get(string $code): array
    {
        return array_map(
            fn (array $item) => $this->itemToMessage($item, $code),
            $this->getItemsRecursively([
                'TableName'                 => $this->tableName,
                'IndexName'                 => 'SKe',
                'KeyConditionExpression'    => "#SKe = :SKe",
                'ExpressionAttributeNames'  => ['#SKe' => 'SKe'],
                'ExpressionAttributeValues' => [':SKe' => ['S' => "SM:{$code}"]],
            ])
        );
    }

    private function itemToMessage(array $item, string $code): Message
    {
        /** @var array $data */
        $data = $this->marshaler->unmarshalItem($item);
        $code = new StationCode($code);

        return new Message(
            new MessageID($data['PK']),
            new MessageCategory($data['category']),
            new MessageBody($data['body']),
            new MessageSeverity($data['severity']),
            [
                new Station(new Code((string) $code), new Name($code->name())),
            ]
        );
    }
}
