<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Thomas\ServiceIndicator\Application\Queries\GetServiceIndicators;
use Thomas\ServiceIndicator\Domain\ServiceIndicatorOptions;
use Thomas\Shared\Framework\Pagination;
use Thomas\Shared\Framework\SuccessResponse;

final class ServiceIndicatorController extends Controller
{
    public function get(Request $request, GetServiceIndicators $query): SuccessResponse
    {
        $options = ServiceIndicatorOptions::fromRequest($request);

        $serviceIndicators = $query->page($options);

        $pagination = new Pagination($options->pageNumber, $options->perPage, $query->count());

        return new SuccessResponse($serviceIndicators, $pagination);
    }
}
