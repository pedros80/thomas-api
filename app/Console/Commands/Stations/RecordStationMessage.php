<?php

declare(strict_types=1);

namespace App\Console\Commands\Stations;

use Illuminate\Console\Command;
use Thomas\Shared\Application\DarwinMessageRouter;
use Thomas\Shared\Infrastructure\MockDarwinMessageFactory;

final class RecordStationMessage extends Command
{
    protected $signature   = 'stations:add-message';
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
        $stations = $this->ask('How many Stations to include in message?', '0');

        $stations = is_array($stations) ? $stations[0] : $stations;

        return (int) $stations;
    }
}
