<?php

namespace App\Console\Commands\RealTimeIncidents;

use Illuminate\Console\Command;
use Thomas\RealTimeIncidents\Application\RTIMessageRouter;
use Thomas\RealTimeIncidents\Infrastructure\MockRTIMessageFactory;

final class AddRealTimeIncident extends Command
{
    protected $signature   = 'rti:add';
    protected $description = 'Record a new Real Time Incident';

    public function handle(RTIMessageRouter $router): void
    {
        $message  = MockRTIMessageFactory::new();
        $router->route($message);

        $this->info('Command to add RTI dispatched.');
    }
}
