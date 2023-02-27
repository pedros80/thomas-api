<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Thomas\RealTimeIncidents\Application\Queries\GetIncidents;

final class RealTimeIncidentsController extends Controller
{
    public function get(GetIncidents $query): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'data'    => $query->get(),
        ]);
    }
}
