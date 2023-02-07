<?php

namespace App\Console\Commands\RealTimeIncidents;

use Illuminate\Console\Command;
use Thomas\RealTimeIncidents\Application\Commands\UpdateIncident;
use Thomas\RealTimeIncidents\Domain\Body;
use Thomas\RealTimeIncidents\Domain\MessageParser;
use Thomas\RealTimeIncidents\Infrastructure\MessageFactory;
use Thomas\Shared\Application\CommandBus;

final class UpdateRealTimeIncident extends Command
{
    protected $signature   = 'rti:update';
    protected $description = 'Update an existing Real Time Incident';

    public function handle(CommandBus $commandBus, MessageParser $messageParser): void
    {
        $message  = MessageFactory::modified();
        $incident = $messageParser->parse($message);

        /** @var Body $body */
        $body   = $incident->body();
        $id     = $incident->id();
        $status = $incident->status();

        $command  = new UpdateIncident($id, $status, $body);

        $commandBus->dispatch($command);
    }
}
