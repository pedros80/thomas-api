<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Application\Commands\Converters;

use Stomp\Transport\Frame;
use Thomas\RealTimeIncidents\Application\Commands\UpdateIncident;
use Thomas\RealTimeIncidents\Domain\Body;
use Thomas\RealTimeIncidents\Domain\IncidentId;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;
use Thomas\Shared\Application\Command;
use Thomas\Shared\Application\MessageToCommand;

final class ModifiedMessageToCommand implements MessageToCommand
{
    public function convert(Frame $message): Command
    {
        $headers = $message->getHeaders();
        $body    = $message->getBody();

        $command = new UpdateIncident(
            new IncidentId($headers['INCIDENT_ID']),
            IncidentMessageStatus::MODIFIED,
            new Body($body),
        );

        return $command;
    }
}
