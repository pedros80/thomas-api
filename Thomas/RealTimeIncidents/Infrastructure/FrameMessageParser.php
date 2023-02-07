<?php

namespace Thomas\RealTimeIncidents\Infrastructure;

use ErrorException;
use Stomp\Transport\Frame;
use Thomas\RealTimeIncidents\Domain\Body;
use Thomas\RealTimeIncidents\Domain\Incident;
use Thomas\RealTimeIncidents\Domain\IncidentID;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;
use Thomas\RealTimeIncidents\Domain\MessageParser;

final class FrameMessageParser implements MessageParser
{
    public function parse(Frame $message): Incident
    {
        $headers = $message->getHeaders();
        $body = $message->getBody();

        return new Incident(
            new IncidentID($headers['INCIDENT_ID']),
            new IncidentMessageStatus($headers['INCIDENT_MESSAGE_STATUS']),
            $body ? new Body($this->parseBody($body)) : null
        );
    }

    private function parseBody(string $body): string
    {
        try {

            $unzipped = gzdecode($body);
            $body     = $unzipped !== false ? $unzipped : $body;
        } catch (ErrorException) {
            // $body wasn't gzipped ¯\_(ツ)_/¯
        }

        return trim($body);
    }
}