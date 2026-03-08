<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Domain\Events;

use Thomas\RealTimeIncidents\Domain\IncidentId;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;
use Thomas\Shared\Domain\Event;

use function Safe\json_decode;

final class IncidentWasRemoved extends Event
{
    public function __construct(
        public readonly IncidentId $id,
        public readonly IncidentMessageStatus $status,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id'     => $this->id,
            'status' => $this->status,
        ];
    }

    public static function deserialize(string $json): static
    {
        /** @var array $payload */
        $payload = json_decode($json, true);

        return new IncidentWasRemoved(
            new IncidentId($payload['id']),
            IncidentMessageStatus::from($payload['status']),
        );
    }
}
