<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Application\Queries;

use Illuminate\Contracts\Cache\Repository;
use Thomas\LiftsAndEscalators\Domain\Assets;
use Thomas\LiftsAndEscalators\Domain\AssetType;
use Thomas\LiftsAndEscalators\Domain\LiftAndEscalatorClient;
use Thomas\Shared\Domain\CRS;

final class GetStationAssets
{
    public function __construct(
        private readonly LiftAndEscalatorClient $client,
        private readonly Repository $cache,
    ) {
    }

    public function get(CRS $station, ?AssetType $type=null): Assets
    {
        /** @var Assets $assets */
        $assets = $this->cache->get("assets|{$station}");

        if (!$assets) {
            $assets = $this->client->getAssetsByStationCode($station);
            $this->cache->put("assets|{$station}", $assets, 10 * 60);
        }

        return match ($type) {
            AssetType::ESCALATOR => $assets->escalators(),
            AssetType::LIFT      => $assets->lifts(),
            default              => $assets,
        };
    }
}
