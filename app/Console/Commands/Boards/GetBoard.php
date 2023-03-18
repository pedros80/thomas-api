<?php

declare(strict_types=1);

namespace App\Console\Commands\Boards;

use Illuminate\Console\Command;
use Pedros80\NREphp\Params\StationCode;
use Thomas\Boards\Domain\BoardService;

final class GetBoard extends Command
{
    protected $signature   = 'board:get {station? : Which Station?}';
    protected $description = "I'm bored, I'm chairman of the board.";

    public function handle(BoardService $boards): void
    {
        $station = $this->getStation();

        $result = $boards->departures($station);

        $stationCode = new StationCode($result->GetStationBoardResult->crs);

        $this->info("Departures Board for {$stationCode->name()}");
        $this->table(['Location Name', 'CRS'], [
            [
                $stationCode->name(),
                (string) $stationCode,
            ],
        ]);
    }

    private function getStation(): string
    {
        $station = $this->argument('station') ?: $this->ask('Which Station?');

        return is_array($station) ? $station[0] : $station;
    }
}
