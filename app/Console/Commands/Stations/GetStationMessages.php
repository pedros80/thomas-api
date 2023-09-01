<?php

declare(strict_types=1);

namespace App\Console\Commands\Stations;

use Illuminate\Console\Command;
use Thomas\Shared\Domain\CRS;
use Thomas\Stations\Application\Queries\GetStationMessages as QueriesGetStationMessages;
use Thomas\Stations\Domain\Message;
use Thomas\Stations\Domain\Station;

final class GetStationMessages extends Command
{
    protected $signature   = 'stations:get-messages {station? : Which Station}';
    protected $description = 'Get all messages by station';

    public function handle(QueriesGetStationMessages $query): void
    {
        $code = $this->getCode();
        $msgs = $query->get($code);

        if (!$msgs) {
            $this->info("No messages found for {$code->name()}");

            return;
        }

        $this->table([
            'ID', 'Category', 'Severity', 'Body', 'Station',
        ], array_map(fn (Message $message) => $this->parseMessage($message), $msgs));
    }

    private function getCode(): CRS
    {
        $code = $this->argument('station') ?: $this->ask('Which Station Code?');

        $code = is_array($code) ? $code[0] : $code;

        return CRS::fromString($code);
    }

    private function parseMessage(Message $message): array
    {
        $message = $message->toArray();

        return [
            $message['id'],
            $message['category'],
            $message['severity'],
            $message['body'],
            array_map(
                fn (Station $station) => $station->toArray()['name'],
                $message['stations']
            )[0],
        ];
    }
}
