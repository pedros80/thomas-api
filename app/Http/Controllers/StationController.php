<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchStationRequest;
use Illuminate\Http\JsonResponse;
use Thomas\LiftsAndEscalators\Application\Queries\GetStationAssets;
use Thomas\LiftsAndEscalators\Domain\AssetType;
use Thomas\Shared\Domain\CRS;
use Thomas\Stations\Application\Queries\GetStationMessages;
use Thomas\Stations\Application\Queries\SearchStations;

final class StationController extends Controller
{
    public function search(SearchStationRequest $request, SearchStations $query): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'data'    => $query->get($request->get('search')),
        ]);
    }

    public function messages(string $station, GetStationMessages $query): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'data'    => $query->get(CRS::fromString($station)),
        ]);
    }

    public function assets(string $station, GetStationAssets $query): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'data'    => $query->get(CRS::fromString($station)),
        ]);
    }

    public function lifts(string $station, GetStationAssets $query): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'data'    => $query->get(CRS::fromString($station), AssetType::LIFT),
        ]);
    }

    public function escalators(string $station, GetStationAssets $query): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'data'    => $query->get(CRS::fromString($station), AssetType::ESCALATOR),
        ]);
    }
}
