<?php

namespace App\Console\Commands\RealTimeIncidents;

use Illuminate\Console\Command;
use Thomas\RealTimeIncidents\Application\Commands\RemoveIncident;
use Thomas\RealTimeIncidents\Domain\MessageParser;
use Thomas\RealTimeIncidents\Infrastructure\MockMessageFactory;
use Thomas\Shared\Application\CommandBus;

final class RemoveRealTimeIncident extends Command
{
    protected $signature   = 'rti:remove';
    protected $description = 'Remove a Real Time Incident';

    public function handle(CommandBus $commandBus, MessageParser $messageParser): void
    {
        $message  = MockMessageFactory::removed();
        $incident = $messageParser->parse($message);
        $command  = new RemoveIncident($incident->id(), $incident->status());

        $commandBus->dispatch($command);

        $this->info('Command dispatched to remove rti.');
    }
}
