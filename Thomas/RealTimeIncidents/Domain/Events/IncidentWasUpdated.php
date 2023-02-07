<?php

namespace Thomas\RealTimeIncidents\Domain\Events;

use Thomas\RealTimeIncidents\Domain\Body;
use Thomas\RealTimeIncidents\Domain\IncidentID;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;
use Thomas\Shared\Domain\Event;

final class IncidentWasUpdated extends Event
{
    public function __construct(
        private IncidentID $id,
        private IncidentMessageStatus $status,
        private Body $body
    ) {
    }

    public function id(): IncidentID
    {
        return $this->id;
    }

    public function status(): IncidentMessageStatus
    {
        return $this->status;
    }

    public function body(): Body
    {
        return $this->body;
    }

    public function toArray(): array
    {
        return [
            'id'     => (string) $this->id,
            'status' => (string) $this->status,
            'body'   => (string) $this->body,
        ];
    }

    public static function deserialize(string $json): static
    {
        $payload = json_decode($json);

        return new IncidentWasUpdated(
            new IncidentID($payload->id),
            new IncidentMessageStatus($payload->status),
            new Body($payload->body)
        );
    }
}
