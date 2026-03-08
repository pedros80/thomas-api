<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Application\Services\CombinedBoardService;
use App\Http\Controllers\Controller;
use Thomas\Shared\Framework\SuccessResponse;

final class BoardController extends Controller
{
    public function __construct(
        private readonly CombinedBoardService $service,
    ) {
    }

    public function departures(string $station): SuccessResponse
    {
        return new SuccessResponse($this->service->getDeparturesBoard($station));
    }

    public function departuresPlatform(string $station, string $platform): SuccessResponse
    {
        return new SuccessResponse($this->service->getPlatformDeparturesBoard($station, $platform));
    }

    public function arrivals(string $station): SuccessResponse
    {
        return new SuccessResponse($this->service->getArrivalsBoard($station));
    }
}
