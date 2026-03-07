<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\DTOs\CombinedBoard;
use Thomas\Boards\Domain\BoardDataService;
use Thomas\RealTimeIncidents\Application\Queries\GetIncidents;
use Thomas\Shared\Domain\CRS;
use Thomas\Stations\Application\Queries\GetStationMessages;

final class CombinedBoardService
{
    public function __construct(
        private readonly BoardDataService $boards,
        private readonly GetIncidents $incidents,
        private readonly GetStationMessages $messages,
    ) {
    }

    public function getDeparturesBoard(string $station): CombinedBoard
    {
        $station = CRS::fromString($station);

        $board = $this->boards->departures($station);

        return new CombinedBoard(
            $board,
            $this->messages->get($station),
            $this->incidents->get($board->operators->toStrings())
        );
    }

    public function getPlatformDeparturesBoard(string $station, string $platform): CombinedBoard
    {
        $station = CRS::fromString($station);

        $board = $this->boards->departuresPlatform($station, $platform);

        return new CombinedBoard(
            $board,
            $this->messages->get($station),
            $this->incidents->get($board->operators->toStrings())
        );
    }

    public function getArrivalsBoard(string $station): CombinedBoard
    {
        $station = CRS::fromString($station);

        $board = $this->boards->arrivals($station);

        return new CombinedBoard(
            $board,
            $this->messages->get($station),
            $this->incidents->get($board->operators->toStrings())
        );
    }
}
