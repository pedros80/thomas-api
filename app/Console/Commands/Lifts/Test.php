<?php

declare(strict_types=1);

namespace App\Console\Commands\Lifts;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Pedros80\LANDEphp\Contracts\LiftsAndEscalators;
use stdClass;
use Thomas\LiftsAndEscalators\Application\Queries\GetStationAssets;
use Thomas\LiftsAndEscalators\Domain\AssetId;
use Thomas\LiftsAndEscalators\Domain\AssetType;
use Thomas\LiftsAndEscalators\Domain\Exceptions\NoAssetsAtThisStation;
use Thomas\LiftsAndEscalators\Domain\LiftAndEscalatorClient;
use Thomas\LiftsAndEscalators\Domain\SensorId;
use Thomas\Shared\Domain\CRS;
use Thomas\Shared\Domain\Exceptions\ExternalDataConnectionFailure;

final class Test extends Command
{
    protected $signature   = 'lifts:test';
    protected $description = 'lifts';

    public function handle(LiftAndEscalatorClient $client): void
    {
        $sensors = $client->getSensors(1, 1);



    }

    // public function handle(GetStationAssets $query): void
    // {

    //     $lifts = $query->get(CRS::fromString('edb'), AssetType::LIFT);

    //     var_dump(count($lifts));

    //     $escalators = $query->get(CRS::fromString('edb'), AssetType::ESCALATOR);

    //     var_dump(count($escalators));

    //     $both = $query->get(CRS::fromString('edb'));

    //     var_dump(count($both));
    // }

    // public function handle(LiftAndEscalatorClient $client)
    // {
    //     for ($i=0; $i < 20; ++$i) {
    //         // $assets = $client->getAssetsByStationCode(CRS::fromString('DAM'));
    //         $asset = $client->getAssetById(new AssetId(1160));
    //     }
    //     // Log::info(json_encode($assets));
    // }
}
