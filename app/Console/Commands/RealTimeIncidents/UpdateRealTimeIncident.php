<?php

declare(strict_types=1);

namespace App\Console\Commands\RealTimeIncidents;

use Illuminate\Console\Command;
use Thomas\RealTimeIncidents\Application\RTIMessageRouter;
use Thomas\RealTimeIncidents\Infrastructure\MockRTIMessageFactory;

final class UpdateRealTimeIncident extends Command
{
    protected $signature   = 'rti:update';
    protected $description = 'Update an existing Real Time Incident';

    public function handle(RTIMessageRouter $router): void
    {
        $message = MockRTIMessageFactory::modified();
        $router->route($message);

        $this->info('Command dispatched to update rti.');
    }
}
