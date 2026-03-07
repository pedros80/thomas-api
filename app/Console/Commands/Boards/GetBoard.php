<?php

declare(strict_types=1);

namespace App\Console\Commands\Boards;

use Illuminate\Console\Command;
use Thomas\Boards\Domain\BoardDataService;
use Thomas\Boards\Domain\Service;
use Thomas\Shared\Domain\CRS;

final class GetBoard extends Command
{
    protected $signature   = 'board:get {station? : Which Station?}';
    protected $description = "I'm bored, I'm chairman of the board.";

    public function handle(BoardDataService $boards): void
    {
        $station = $this->getStation();

        $data   = [];
        $data[] = $boards->departures($station);
        $data[] = $boards->arrivals($station);
        $data[] = $boards->departuresPlatform($station, '1');

        foreach ($data as $board) {

            $this->info("{$board->type->value} Board for {$board->title}");
            $this->table(
                ['Time', $board->type->value, 'Platform', 'Expected'],
                $board->services->map(fn (Service $service) => $service->display())
            );
        }
    }

    private function getStation(): CRS
    {
        $station = $this->argument('station') ?: $this->ask('Which Station?');

        $station = is_array($station) ? $station[0] : $station;

        return CRS::fromString($station);
    }
}
