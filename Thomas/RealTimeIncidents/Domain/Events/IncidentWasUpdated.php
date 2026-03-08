<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Domain\Events;

use Thomas\RealTimeIncidents\Domain\Body;
use Thomas\RealTimeIncidents\Domain\IncidentId;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;
use Thomas\Shared\Domain\Event;

use function Safe\json_decode;

final class IncidentWasUpdated extends Event
{
    public function __construct(
        public readonly IncidentId $id,
        public readonly IncidentMessageStatus $status,
        public readonly Body $body,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id'     => $this->id,
            'status' => $this->status,
            'body'   => (string) $this->body,
        ];
    }

    public static function deserialize(string $json): static
    {
        /** @var array $payload */
        $payload = json_decode($json, true);

        return new IncidentWasUpdated(
            new IncidentId($payload['id']),
            IncidentMessageStatus::from($payload['status']),
            new Body($payload['body']),
        );
    }
}
