<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain;

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

final class Asset implements JsonSerializable
{
    public function __construct(
        private AssetId $assetId,
        private AssetType $assetType,
        private CRS $crs,
        private Description $description,
        private DisplayName $displayName,
        private PRN $prn,
        private ?SensorId $sensorId,
        private ?AssetStatus $status,
        private ?Location $location
    ) {
    }

    public function isLift(): bool
    {
        return (string) $this->assetType === AssetType::LIFT;
    }

    public function isEscalator(): bool
    {
        return (string) $this->assetType === AssetType::ESCALATOR;
    }

    public function toArray(): array
    {
        return [
            'id'          => $this->assetId,
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
            new AssetType($asset['type']),
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
