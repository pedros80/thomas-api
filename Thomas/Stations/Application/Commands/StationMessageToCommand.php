<?php

declare(strict_types=1);

namespace Thomas\Stations\Application\Commands;

use SimpleXMLElement;
use Stomp\Transport\Frame;
use Thomas\Shared\Application\Command;
use Thomas\Shared\Application\MessageToCommand;
use Thomas\Shared\Domain\CRS;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageId;
use Thomas\Stations\Domain\MessageSeverity;
use Thomas\Stations\Domain\Stations;

use function Safe\gzdecode;

final class StationMessageToCommand implements MessageToCommand
{
    public function convert(Frame $message): Command
    {
        /** @var string $body */
        $body = gzdecode($message->getBody());

        $xml = new SimpleXMLElement($body);

        $stations = [];

        foreach ($xml->uR->OW->children('ns7', true)->Station as $station) {
            $stationCode = CRS::fromString((string) $station->attributes()?->crs ?: '');

            $stations[] = [
                'code' => (string) $stationCode,
                'name' => $stationCode->name(),
            ];
        }

        return new RecordStationMessage(
            new MessageId((string) $xml->uR->OW['id']),
            MessageCategory::from((string) $xml->uR->OW['cat']),
            new MessageBody(trim((string) $xml->uR->OW->children('ns7', true)->Msg)),
            MessageSeverity::from((int) $xml->uR->OW['sev']),
            Stations::fromArray($stations),
        );
    }
}
