<?php

declare(strict_types=1);

namespace Thomas\Boards\Providers\RealTimeTrains;

use Pedros80\RTTphp\Contracts\Locations;
use stdClass;
use Thomas\Boards\Domain\Board;
use Thomas\Boards\Domain\BoardDataService;
use Thomas\Shared\Domain\CRS;

final class RealTimeTrainsService implements BoardDataService
{
    public function __construct(
        private Locations $locations,
        private RTTBoardMapper $mapper,
        private int $numRows
    ) {
    }

    public function departures(CRS $station): Board
    {
        $location = (object) $this->locations->search(
            station: (string) $station,
        );

        $location->services = $this->parseServices($location->services ?? []);

        return $this->mapper->toDepartureBoard($location);
    }

    public function arrivals(CRS $station): Board
    {
        $location = (object) $this->locations->search(
            station: (string) $station,
            arrivals: true
        );

        $location->services = $this->parseServices($location->services ?? []);

        return $this->mapper->toArrivalBoard($location);
    }

    public function departuresPlatform(CRS $station, string $platform): Board
    {
        $location = (object) $this->locations->search(
            station: (string) $station,
        );

        $location->services = $this->parseServices($location->services ?? [], $platform);

        return $this->mapper->toPlatformBoard($location);
    }

    private function parseServices(array $services, ?string $platform=null): array
    {
        return array_slice(
            array_filter(
                $services,
                fn (stdClass $service) => $this->filterTrainServices($service, $platform)
            ),
            0,
            $this->numRows
        );
    }

    private function filterTrainServices(stdClass $service, ?string $platform=null): bool
    {
        $isTrain = $service->serviceType === 'train';

        if (!$platform) {
            $platformMatches = true;
        } else {
            $platformMatches = $service->locationDetail->platform === $platform;
        }

        return $isTrain && $platformMatches;
    }
}
