<?php

declare(strict_types=1);

namespace Thomas\Tube\Providers\TfL;

use Thomas\Tube\Domain\Arrival;
use Thomas\Tube\Domain\Arrivals;
use Thomas\Tube\Domain\TubeLineId;
use Thomas\Tube\Domain\TubeLineIds;

final class TfLMapper
{
    public function parseNaptans(array $naptans): array
    {
        return array_reduce(
            $naptans,
            function (array $naptans, array $naptan) {
                $naptans[$naptan['naptanId']] = [
                    'name'     => $naptan['commonName'],
                    'location' => [
                        'lat' => $naptan['lat'],
                        'lon' => $naptan['lon'],
                    ],
                ];

                return $naptans;
            },
            []
        );
    }

    public function parseTubeLines(TubeLineIds $lines): array
    {
        return $lines->map(fn (TubeLineId $line) => $line->toArray());
    }

    public function parseArrivals(array $arrivals): Arrivals
    {
        return new Arrivals(
            array_map(
                fn (array $arrival) => Arrival::fromArray($arrival),
                $arrivals
            )
        );
    }
}
