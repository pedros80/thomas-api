<?php

declare(strict_types=1);

namespace Thomas\Boards\Domain;

use JsonSerializable;

final class Service implements JsonSerializable
{
    public function __construct(
        private string $scheduledTime,
        private string $serviceId,
        private string $destination,
        private string $platform,
        private string $estimatedTime,
        private string $operator,
        private string $callingAt,
        private bool $isCancelled,
        private ?string $cancelledReason=null
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
