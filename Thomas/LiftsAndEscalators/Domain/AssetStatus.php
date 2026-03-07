<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
use Thomas\LiftsAndEscalators\Domain\SensorId;
use Thomas\LiftsAndEscalators\Domain\Status;

final class AssetStatus implements Arrayable, JsonSerializable
{
    public function __construct(
        public readonly Status $status,
        public readonly SensorId $sensorId,
        public readonly bool $isolated,
        public readonly bool $engineerOnSite,
        public readonly bool $independent,
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
            Status::from($status['status']),
            new SensorId((int) $status['sensorId']),
            $status['isolated'],
            $status['engineerOnSite'],
            $status['independent']
        );
    }
}
