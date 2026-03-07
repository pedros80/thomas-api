<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Domain;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
use Thomas\RealTimeIncidents\Domain\Body;
use Thomas\RealTimeIncidents\Domain\IncidentId;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;

final class Incident implements Arrayable, JsonSerializable
{
    public function __construct(
        public readonly IncidentId $id,
        public readonly IncidentMessageStatus $status,
        public readonly ?Body $body,
    ) {
    }

    public function toArray(): array
    {
        $out = [
            'id'     => $this->id,
            'status' => $this->status,
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
