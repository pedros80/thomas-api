<?php

declare(strict_types=1);

namespace App\Console\Commands\Boards;

use Illuminate\Console\Command;
use RuntimeException;
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
        $station = $this->argument('station');

        if ($station === null || $station === '') {
            $station = $this->ask('Which Station?');
        }

        if (is_array($station)) {
            $station = $station[0] ?? null;
        }

        if (!is_string($station) || $station === '') {
            throw new RuntimeException('Station must be a non-empty string.');
        }

        return CRS::fromString($station);
    }
}
