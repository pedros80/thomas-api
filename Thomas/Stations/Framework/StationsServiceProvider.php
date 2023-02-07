<?php

namespace Thomas\Stations\Framework;

use Illuminate\Support\ServiceProvider;
use Thomas\Stations\Application\Queries\SearchStations;
use Thomas\Stations\Domain\StationService;
use Thomas\Stations\Infrastructure\ArrayStationService;

final class StationsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->bindStationService();
        $this->bindStationQueries();
    }

    private function bindStationService(): void
    {
        $this->app->bind(
            StationService::class,
            fn () => new ArrayStationService()
        );
    }

    private function bindStationQueries(): void
    {
        $this->app->bind(
            SearchStations::class,
            fn () => new SearchStations($this->app->make(StationService::class))
        );
    }
}
