<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Domain\Events;

use Thomas\RealTimeIncidents\Domain\IncidentID;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;
use Thomas\Shared\Domain\Event;

final class IncidentWasRemoved extends Event
{
    public function __construct(
        private IncidentID $id,
        private IncidentMessageStatus $status,
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

    public function toArray(): array
    {
        return [
            'id'     => (string) $this->id,
            'status' => (string) $this->status,
        ];
    }

    public static function deserialize(string $json): static
    {
        $payload = json_decode($json);

        return new IncidentWasRemoved(
            new IncidentID($payload->id),
            new IncidentMessageStatus($payload->status)
        );
    }
}
