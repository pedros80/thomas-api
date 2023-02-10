<?php

namespace App\Console\Commands\RealTimeIncidents;

use Illuminate\Console\Command;
use Thomas\RealTimeIncidents\Application\Commands\AddIncident;
use Thomas\RealTimeIncidents\Domain\Body;
use Thomas\RealTimeIncidents\Domain\MessageParser;
use Thomas\RealTimeIncidents\Infrastructure\MockMessageFactory;
use Thomas\Shared\Application\CommandBus;

final class AddRealTimeIncident extends Command
{
    protected $signature   = 'rti:add';
    protected $description = 'Record a new Real Time Incident';

    public function handle(CommandBus $commandBus, MessageParser $messageParser): void
    {
        $message  = MockMessageFactory::new();
        $incident = $messageParser->parse($message);

        /** @var Body $body */
        $body   = $incident->body();
        $id     = $incident->id();
        $status = $incident->status();

        $command = new AddIncident($id, $status, $body);

        $commandBus->dispatch($command);
    }
}
