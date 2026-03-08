<?php

declare(strict_types=1);

namespace App\Console\Commands\Stations;

use Illuminate\Console\Command;
use RuntimeException;
use Thomas\Stations\Application\Queries\SearchStations;
use Thomas\Stations\Domain\Station;
use Thomas\Stations\Domain\Stations;

final class SearchStationsByNameOrCode extends Command
{
    protected $signature   = 'stations:search {search? : Term to search for}';
    protected $description = 'Search station names and return code';

    public function handle(SearchStations $query): void
    {
        $this->displayResults($query->get($this->getSearchTerm()));
    }

    private function getSearchTerm(): string
    {
        $search = $this->argument('search');

        if ($search === null || $search === '') {
            $search = $this->ask('Enter Search Term?');
        }

        if (is_array($search)) {
            $search = $search[0] ?? null;
        }

        if (!is_string($search) || $search === '') {
            throw new RuntimeException('Search term must be a non-empty string.');
        }

        return $search;
    }

    private function displayResults(Stations $stations): void
    {
        $numStations = count($stations);
        $s           = $numStations === 1 ? '' : 's';

        $this->info("Found {$numStations} Station{$s}");

        if ($numStations === 0) {
            return;
        }

        $this->table(
            ['Code', 'Name'],
            $stations->map(fn (Station $station) => $station->toArray())
        );
    }
}
