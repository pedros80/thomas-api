<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Thomas\Boards\Application\Queries\GetPlatformBoardDepartures;
use Thomas\Boards\Application\Queries\GetStationBoardArrivals;
use Thomas\Boards\Application\Queries\GetStationBoardDepartures;
use Thomas\RealTimeIncidents\Application\Queries\GetIncidents;
use Thomas\Stations\Application\Queries\GetStationMessages;

final class BoardController extends Controller
{
    public function departures(
        GetStationBoardDepartures $departures,
        GetStationMessages $messages,
        GetIncidents $incidents,
        string $station
    ): JsonResponse {
        $board = $departures->get($station);

        return new JsonResponse([
            'success' => true,
            'data'    => [
                'board'     => $board->GetStationBoardResult,
                'messages'  => $messages->get($station),
                'incidents' => $incidents->get($board->operators),
            ],
        ]);
    }

    public function departuresPlatform(
        GetPlatformBoardDepartures $departures,
        GetStationMessages $messages,
        GetIncidents $incidents,
        string $station,
        string $platform
    ): JsonResponse {
        $board = $departures->get($station, $platform);

        return new JsonResponse([
            'success' => true,
            'data'    => [
                'board'     => $board->GetStationBoardResult,
                'messages'  => $messages->get($station),
                'incidents' => $incidents->get($board->operators),
            ],
        ]);
    }

    public function arrivals(
        GetStationBoardArrivals $arrivals,
        GetStationMessages $messages,
        GetIncidents $incidents,
        string $station
    ): JsonResponse {
        $board = $arrivals->get($station);

        return new JsonResponse([
            'success' => true,
            'data'    => [
                'board'     => $board->GetStationBoardResult,
                'message'   => $messages->get($station),
                'incidents' => $incidents->get($board->operators),
            ],
        ]);
    }
}
