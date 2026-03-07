<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Thomas\RealTimeIncidents\Application\Queries\GetIncidents;
use Thomas\Shared\Framework\SuccessResponse;

final class RealTimeIncidentsController extends Controller
{
    public function get(GetIncidents $query): SuccessResponse
    {
        return new SuccessResponse($query->get());
    }
}
