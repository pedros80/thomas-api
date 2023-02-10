<?php

namespace App\Console\Commands\Stations;

use Illuminate\Console\Command;
use Thomas\Shared\Application\MessageRouter;
use Thomas\Stations\Infrastructure\MockMessageFactory;

final class RecordStationMessage extends Command
{
    protected $signature   = 'stations:add-message {stations=yes : Include some stations in the message?}';
    protected $description = 'Record a station message';

    public function handle(MessageRouter $router): void
    {
        $stations = $this->argument('stations');
        $method   = $stations === 'yes' ? 'stations' : 'noStations';
        $router->route(MockMessageFactory::$method());
    }
}
