<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Thomas\Boards\Application\Queries\GetPlatformBoardDepartures;
use Thomas\Boards\Application\Queries\GetStationBoardArrivals;
use Thomas\Boards\Application\Queries\GetStationBoardDepartures;

final class BoardController extends Controller
{
    public function departures(GetStationBoardDepartures $query, string $station): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'data'    => $query->get($station)->GetStationBoardResult,
        ]);
    }

    public function departuresPlatform(GetPlatformBoardDepartures $query, string $station, string $platform): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'data'    => $query->get($station, $platform)->GetStationBoardResult,
        ]);
    }

    public function arrivals(GetStationBoardArrivals $query, string $station): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'data'    => $query->get($station)->GetStationBoardResult,
        ]);
    }
}
