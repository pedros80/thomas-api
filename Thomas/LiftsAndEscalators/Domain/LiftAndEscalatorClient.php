<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain;

use Thomas\LiftsAndEscalators\Domain\Asset;
use Thomas\LiftsAndEscalators\Domain\AssetId;
use Thomas\LiftsAndEscalators\Domain\Assets;
use Thomas\LiftsAndEscalators\Domain\AssetStatus;
use Thomas\LiftsAndEscalators\Domain\AssetStatuses;
use Thomas\LiftsAndEscalators\Domain\SensorId;
use Thomas\Shared\Domain\CRS;

interface LiftAndEscalatorClient
{
    public function getAssetsByStationCode(CRS $station): Assets;
    public function getAssetById(AssetId $assetId): Asset;
    public function getSensorById(SensorId $sensorId): AssetStatus;
    public function getSensors(int $num=50, int $offset=0): AssetStatuses;
}
