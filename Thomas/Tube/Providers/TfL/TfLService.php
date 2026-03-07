<?php

declare(strict_types=1);

namespace Thomas\Tube\Providers\TfL;

use Pedros80\TfLphp\Contracts\LineService;
use Thomas\Shared\Domain\NaptanId;
use Thomas\Tube\Domain\Arrivals;
use Thomas\Tube\Domain\TubeLineId;
use Thomas\Tube\Domain\TubeService;
use Thomas\Tube\Providers\TfL\TfLMapper;

final class TfLService implements TubeService
{
    public function __construct(
        private readonly LineService $lineService,
        private readonly TfLMapper $mapper,
    ) {
    }

    public function getArrivalsByNaptan(NaptanId $naptanId): Arrivals
    {
        return $this->mapper->parseArrivals(
            $this->lineService->getArrivalsByLineAndStop(
                TubeLineId::all()->map(fn (TubeLineId $line) => (string) $line),
                (string) $naptanId,
            )
        );
    }

    public function getTubeLines(): array
    {
        return $this->mapper->parseTubeLines(TubeLineId::all());
    }

    public function getNaptansByLine(TubeLineId $line): array
    {
        return $this->mapper->parseNaptans($this->lineService->getServingStations((string) $line));
    }
}
