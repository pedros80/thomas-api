<?php

declare(strict_types=1);

namespace App\Console\Commands\Stations;

use Illuminate\Console\Command;
use Thomas\Stations\Application\Queries\SearchStations;
use Thomas\Stations\Domain\Station;

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
        $search = $this->argument('search') ?: $this->ask('Enter Search Term?');

        return is_array($search) ? $search[0] : $search;
    }

    private function displayResults(array $results): void
    {
        $numResults = count($results);
        $s          = $numResults === 1 ? '' : 's';

        $this->info("Found {$numResults} Station{$s}");

        if ($numResults === 0) {
            return;
        }

        $this->table(['Code', 'Name'], array_map(fn (Station $station) => $station->toArray(), $results));
    }
}
