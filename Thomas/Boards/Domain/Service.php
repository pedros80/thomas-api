<?php

declare(strict_types=1);

namespace Thomas\Boards\Domain;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

final class Service implements Arrayable, JsonSerializable
{
    public function __construct(
        public readonly string $scheduledTime,
        public readonly string $serviceId,
        public readonly string $destination,
        public readonly string $platform,
        public readonly string $estimatedTime,
        public readonly string $operator,
        public readonly string $callingAt,
        public readonly bool $isCancelled,
        public readonly ?string $cancelledReason=null
    ) {
    }

    public function toArray(): array
    {
        return [
            'scheduledTime' => $this->scheduledTime,
            'serviceId'     => $this->serviceId,
            'destination'   => $this->destination,
            'platform'      => $this->platform,
            'estimatedTime' => $this->estimatedTime,
            'operator'      => $this->operator,
            'callingAt'     => $this->callingAt,
            'cancelled'     => $this->isCancelled,
            'reason'        => $this->cancelledReason,
        ];
    }

    public function display(): array
    {
        return [
            'scheduledTime' => $this->scheduledTime,
            'destination'   => $this->destination,
            'platform'      => $this->platform,
            'estimatedTime' => $this->estimatedTime,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
