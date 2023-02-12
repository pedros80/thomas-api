<?php

namespace App\Console\Commands\RealTimeIncidents;

use Illuminate\Console\Command;
use Thomas\RealTimeIncidents\Application\RTIMessageRouter;
use Thomas\RealTimeIncidents\Infrastructure\MockRTIMessageFactory;

final class RemoveRealTimeIncident extends Command
{
    protected $signature   = 'rti:remove';
    protected $description = 'Remove a Real Time Incident';

    public function handle(RTIMessageRouter $router): void
    {
        $message = MockRTIMessageFactory::removed();
        $router->route($message);

        $this->info('Command dispatched to remove rti.');
    }
}
