<?php

declare(strict_types=1);

namespace Thomas\Boards\Providers\RealTimeTrains;

use Pedros80\RTTphp\Contracts\Locations;
use Pedros80\RTTphp\Contracts\ServiceInformation;
use stdClass;
use Thomas\Boards\Domain\Board;
use Thomas\Boards\Domain\BoardDataService;
use Thomas\Boards\Providers\RealTimeTrains\RunDate;
use Thomas\Shared\Domain\CRS;

final class RealTimeTrainsService implements BoardDataService
{
    public function __construct(
        private Locations $locations,
        private ServiceInformation $services,
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

        $board = $this->mapper->toDepartureBoard($location);

        return $board;
    }

    public function arrivals(CRS $station): Board
    {
        $location = (object) $this->locations->search(
            station: (string) $station,
            arrivals: true
        );

        $location->services = $this->parseServices($location->services ?? []);

        $board = $this->mapper->toArrivalBoard($location);

        return $board;
    }

    public function departuresPlatform(CRS $station, string $platform): Board
    {
        $location = (object) $this->locations->search(
            station: (string) $station,
        );

        $location->services = $this->parseServices($location->services ?? [], $platform);

        foreach ($location->services as $service) {
            $service->callingPoints = $this->getServiceCallingPoints($service, $station);
        }

        $board = $this->mapper->toPlatformBoard($location);

        return $board;
    }

    private function getServiceCallingPoints(stdClass $service, CRS $station): array
    {
        $info      = $this->services->search($service->serviceUid, (string) RunDate::fromString($service->runDate));
        $locations = $info->locations;

        $here = 0;

        foreach ($locations as $idx => $calling) {
            if ($calling->crs === (string) $station) {
                $here = $idx;

                break;
            }
        }

        return array_slice($locations, $here + 1);
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

        if (!$isTrain) {
            return false;
        }

        if (!$platform) {
            $platformMatches = true;
        } else {
            $platformMatches = $service->locationDetail->platform === $platform;
        }

        return $platformMatches;
    }
}
