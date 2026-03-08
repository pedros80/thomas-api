<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
use Thomas\LiftsAndEscalators\Domain\AssetId;
use Thomas\LiftsAndEscalators\Domain\AssetStatus;
use Thomas\LiftsAndEscalators\Domain\AssetType;
use Thomas\LiftsAndEscalators\Domain\Description;
use Thomas\LiftsAndEscalators\Domain\DisplayName;
use Thomas\LiftsAndEscalators\Domain\Location;
use Thomas\LiftsAndEscalators\Domain\PRN;
use Thomas\LiftsAndEscalators\Domain\SensorId;
use Thomas\Shared\Domain\CRS;

final class Asset implements Arrayable, JsonSerializable
{
    public function __construct(
        public readonly AssetId $id,
        public readonly AssetType $assetType,
        public readonly CRS $crs,
        public readonly Description $description,
        public readonly DisplayName $displayName,
        public readonly PRN $prn,
        public readonly ?SensorId $sensorId,
        public readonly ?AssetStatus $status,
        public readonly ?Location $location,
    ) {
    }

    public function isLift(): bool
    {
        return $this->assetType === AssetType::LIFT;
    }

    public function isEscalator(): bool
    {
        return $this->assetType === AssetType::ESCALATOR;
    }

    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'type'        => $this->assetType,
            'crs'         => $this->crs,
            'description' => $this->description,
            'location'    => $this->location,
            'displayName' => $this->displayName,
            'prn'         => $this->prn,
            'sensorId'    => $this->sensorId,
            'status'      => $this->status,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public static function fromArray(array $asset): Asset
    {
        return new Asset(
            new AssetId((int) $asset['id']),
            AssetType::from($asset['type']),
            CRS::fromString($asset['crs']),
            new Description($asset['description']),
            new DisplayName($asset['displayName']),
            new PRN((int) $asset['prn']),
            isset($asset['sensorId']) ? new SensorId((int) $asset['sensorId']) : null,
            isset($asset['status']) ? AssetStatus::fromArray($asset['status']) : null,
            isset($asset['location']) ? new Location($asset['location']) : null,
        );
    }
}
