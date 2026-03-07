<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Domain\Events;

use stdClass;
use Thomas\RealTimeIncidents\Domain\IncidentID;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;
use Thomas\Shared\Domain\Event;

use function Safe\json_decode;

final class IncidentWasRemoved extends Event
{
    public function __construct(
        public readonly IncidentID $id,
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
        /** @var stdClass $payload */
        $payload = json_decode($json);

        return new IncidentWasRemoved(
            new IncidentID($payload->id),
            IncidentMessageStatus::from($payload->status)
        );
    }
}
