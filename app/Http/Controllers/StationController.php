<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Thomas\Stations\Application\Queries\SearchStations;

final class StationController extends Controller
{
    public function search(Request $request, SearchStations $query): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'data'    => $query->get($request->get('search')),
        ]);
    }
}
