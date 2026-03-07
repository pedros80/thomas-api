<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Thomas\Shared\Domain\NaptanId;
use Thomas\Shared\Framework\SuccessResponse;
use Thomas\Tube\Application\Queries\GetNaptansByLine;
use Thomas\Tube\Domain\TubeLineId;
use Thomas\Tube\Domain\TubeService;

final class TubeController extends Controller
{
    public function lines(TubeService $tubeService): SuccessResponse
    {
        return new SuccessResponse($tubeService->getTubeLines());
    }

    public function naptans(GetNaptansByLine $getNaptansByLine, string $line): SuccessResponse
    {
        return new SuccessResponse($getNaptansByLine->get(TubeLineId::fromString($line)));
    }

    public function arrivals(TubeService $tubeService, string $naptan): SuccessResponse
    {
        return new SuccessResponse($tubeService->getArrivalsByNaptan(new NaptanId($naptan)));
    }
}
