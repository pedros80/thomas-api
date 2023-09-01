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
        $data[] = $boards->departures($station)->toArray();
        $data[] = $boards->arrivals($station)->toArray();
        $data[] = $boards->departuresPlatform($station, '2')->toArray();

        foreach ($data as $board) {
            $this->info("{$board['type']} Board for {$board['title']}");
            $this->table(
                ['Time', $board['type'], 'Platform', 'Expected'],
                array_map(
                    fn (Service $service) => $service->display(),
                    $board['services']
                )
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
