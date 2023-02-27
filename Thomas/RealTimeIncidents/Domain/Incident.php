<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Domain;

use JsonSerializable;
use Thomas\RealTimeIncidents\Domain\IncidentID;

final class Incident implements JsonSerializable
{
    public function __construct(
        private IncidentID $id,
        private IncidentMessageStatus $status,
        private ?Body $body
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

    public function body(): ?Body
    {
        return $this->body;
    }

    public function toArray(): array
    {
        $out = [
            'id'     => (string) $this->id,
            'status' => (string) $this->status,
        ];

        if ($this->body) {
            $out['body'] = $this->body->toArray();
        }

        return $out;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
