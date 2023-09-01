<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain;

use JsonSerializable;
use Thomas\LiftsAndEscalators\Domain\SensorId;
use Thomas\LiftsAndEscalators\Domain\Status;

final class AssetStatus implements JsonSerializable
{
    public function __construct(
        private Status $status,
        private SensorId $sensorId,
        private bool $isolated,
        private bool $engineerOnSite,
        private bool $independent
    ) {

    }

    public function toArray(): array
    {
        return [
            'status'         => $this->status,
            'sensorId'       => $this->sensorId,
            'isolated'       => $this->isolated,
            'engineerOnSite' => $this->engineerOnSite,
            'independent'    => $this->independent,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public static function fromArray(array $status): AssetStatus
    {
        return new AssetStatus(
            new Status($status['status']),
            new SensorId((int) $status['sensorId']),
            $status['isolated'],
            $status['engineerOnSite'],
            $status['independent']
        );
    }
}
