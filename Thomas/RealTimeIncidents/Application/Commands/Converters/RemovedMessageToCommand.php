<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Application\Commands\Converters;

use Stomp\Transport\Frame;
use Thomas\RealTimeIncidents\Application\Commands\RemoveIncident;
use Thomas\RealTimeIncidents\Domain\IncidentID;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;
use Thomas\Shared\Application\Command;
use Thomas\Shared\Application\MessageToCommand;

final class RemovedMessageToCommand implements MessageToCommand
{
    public function convert(Frame $message): Command
    {
        $headers = $message->getHeaders();

        $command = new  RemoveIncident(
            new IncidentID($headers['INCIDENT_ID']),
            IncidentMessageStatus::removed(),
        );

        return $command;
    }
}
