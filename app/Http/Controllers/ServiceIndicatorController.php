<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Thomas\ServiceIndicator\Application\Queries\GetServiceIndicators;

final class ServiceIndicatorController extends Controller
{
    public function get(GetServiceIndicators $query): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'data'    => $query->get(),
        ]);
    }
}
