<?php

declare(strict_types=1);

namespace Thomas\Boards\Providers\NationalRailEnquiries;

use Pedros80\NREphp\Contracts\Boards;
use stdClass;
use Thomas\Boards\Domain\Board;
use Thomas\Boards\Domain\BoardDataService;
use Thomas\Shared\Domain\CRS;

final class NationalRailEnquiriesService implements BoardDataService
{
    public function __construct(
        private Boards $boards,
        private NREBoardMapper $mapper,
        private int $numRows
    ) {
    }

    public function departures(CRS $station): Board
    {
        $data  = $this->getBoard($station, 'getDepBoardWithDetails');
        $board = $this->mapper->toDepartureBoard($data);

        return $board;
    }

    public function arrivals(CRS $station): Board
    {
        $data  = $this->getBoard($station, 'getArrBoardWithDetails');
        $board = $this->mapper->toArrivalBoard($data);

        return $board;
    }

    public function departuresPlatform(CRS $station, string $platform): Board
    {
        $data = $this->getBoard($station, 'getDepBoardWithDetails');

        $services = $data->GetStationBoardResult->trainServices?->service ?? [];

        $platformServices = array_filter(
            $services,
            fn (stdClass $service) => isset($service->platform) && $service->platform === $platform
        );

        if (isset($data->GetStationBoardResult->trainServices->service)) {
            $data->GetStationBoardResult->trainServices->service = $platformServices;
        }

        $board = $this->mapper->toPlatformBoard($data);

        return $board;
    }

    private function getBoard(CRS $station, string $method): stdClass
    {
        return $this->boards->$method($this->numRows, (string) $station);
    }
}
