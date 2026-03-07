<?php

declare(strict_types=1);

namespace App\Console\Commands\Stations;

use Illuminate\Console\Command;
use RuntimeException;
use Thomas\Shared\Application\DarwinMessageRouter;
use Thomas\Shared\Infrastructure\MockDarwinMessageFactory;

final class RecordStationMessage extends Command
{
    protected $signature   = 'stations:add-message {numStations? : How many stations?}';
    protected $description = 'Record a station message';

    public function handle(DarwinMessageRouter $router): void
    {
        $numberOfStations = $this->getNumberOfStations();
        $router->route(MockDarwinMessageFactory::stationMessage($numberOfStations));

        $s = $numberOfStations === 1 ? '' : 's';
        $this->info("Message routed: includes {$numberOfStations} station{$s}.");
    }

    private function getNumberOfStations(): int
    {
        $stations = $this->argument('numStations');

        if ($stations === null || $stations === '') {
            $stations = $this->ask('How many Stations to include in message?', '0');
        }

        if (is_array($stations)) {
            $stations = $stations[0] ?? null;
        }

        if (!is_string($stations) && !is_int($stations)) {
            throw new RuntimeException('Number of stations must be numeric.');
        }

        if (! is_numeric((string) $stations)) {
            throw new RuntimeException('Number of stations must be numeric.');
        }

        return (int) $stations;
    }
}
