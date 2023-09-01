<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Thomas\Boards\Application\Queries\GetPlatformBoardDepartures;
use Thomas\Boards\Application\Queries\GetStationBoardArrivals;
use Thomas\Boards\Application\Queries\GetStationBoardDepartures;
use Thomas\RealTimeIncidents\Application\Queries\GetIncidents;
use Thomas\Shared\Domain\CRS;
use Thomas\Stations\Application\Queries\GetStationMessages;

final class BoardController extends Controller
{
    public function departures(
        GetStationBoardDepartures $departures,
        GetStationMessages $messages,
        GetIncidents $incidents,
        string $station
    ): JsonResponse {

        $station = CRS::fromString($station);

        $board = $departures->get($station);

        return new JsonResponse([
            'success' => true,
            'data'    => [
                'board'     => $board,
                'messages'  => $messages->get($station),
                'incidents' => $incidents->get($board->toArray()['operators']),
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

        $station = CRS::fromString($station);

        $board = $departures->get($station, $platform);

        return new JsonResponse([
            'success' => true,
            'data'    => [
                'board'     => $board,
                'messages'  => $messages->get($station),
                'incidents' => $incidents->get($board->toArray()['operators']),
            ],
        ]);
    }

    public function arrivals(
        GetStationBoardArrivals $arrivals,
        GetStationMessages $messages,
        GetIncidents $incidents,
        string $station
    ): JsonResponse {

        $station = CRS::fromString($station);

        $board = $arrivals->get($station);

        return new JsonResponse([
            'success' => true,
            'data'    => [
                'board'     => $board,
                'message'   => $messages->get($station),
                'incidents' => $incidents->get($board->toArray()['operators']),
            ],
        ]);
    }
}
