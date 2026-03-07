<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchStationRequest;
use Thomas\LiftsAndEscalators\Application\Queries\GetStationAssets;
use Thomas\LiftsAndEscalators\Domain\AssetType;
use Thomas\Shared\Domain\CRS;
use Thomas\Shared\Framework\SuccessResponse;
use Thomas\Stations\Application\Queries\GetStationMessages;
use Thomas\Stations\Application\Queries\SearchStations;

final class StationController extends Controller
{
    public function search(SearchStationRequest $request, SearchStations $query): SuccessResponse
    {
        $validated = $request->validated();

        /** @var string $search */
        $search = $validated['search'];

        return new SuccessResponse($query->get($search));
    }

    public function messages(string $station, GetStationMessages $query): SuccessResponse
    {
        return new SuccessResponse($query->get(CRS::fromString($station)));
    }

    public function assets(string $station, GetStationAssets $query): SuccessResponse
    {
        return new SuccessResponse($query->get(CRS::fromString($station)));
    }

    public function lifts(string $station, GetStationAssets $query): SuccessResponse
    {
        return new SuccessResponse($query->get(CRS::fromString($station), AssetType::LIFT));
    }

    public function escalators(string $station, GetStationAssets $query): SuccessResponse
    {
        return new SuccessResponse($query->get(CRS::fromString($station), AssetType::ESCALATOR));
    }
}
