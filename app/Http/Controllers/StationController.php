<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchStationRequest;
use Illuminate\Http\JsonResponse;
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
            'data'    => $query->get($station),
        ]);
    }
}
