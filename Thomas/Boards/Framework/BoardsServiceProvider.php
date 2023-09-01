<?php

declare(strict_types=1);

namespace Thomas\Boards\Framework;

use Illuminate\Support\ServiceProvider;
use Thomas\Boards\Application\Queries\GetPlatformBoardDepartures;
use Thomas\Boards\Application\Queries\GetStationBoardArrivals;
use Thomas\Boards\Application\Queries\GetStationBoardDepartures;
use Thomas\Boards\Domain\BoardDataService;
use Thomas\Boards\Providers\NationalRailEnquiries\NationalRailEnquiriesService;
use Thomas\Boards\Providers\RealTimeTrains\RealTimeTrainsService;

final class BoardsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->bindBoardDataService();
        $this->bindBoardQueries();
    }

    private function bindBoardDataService(): void
    {
        switch (config('services.board.provider')) {
            case 'rtt':
                $this->app->bind(
                    BoardDataService::class,
                    fn () => $this->app->make(RealTimeTrainsService::class)
                );

                break;

            default:
                $this->app->bind(
                    BoardDataService::class,
                    fn () => $this->app->make(NationalRailEnquiriesService::class)
                );

                break;
        }
    }

    private function bindBoardQueries(): void
    {
        $queries = [
            GetPlatformBoardDepartures::class,
            GetStationBoardDepartures::class,
            GetStationBoardArrivals::class,
        ];

        foreach ($queries as $query) {
            $this->app->bind(
                $query,
                fn () => new $query($this->app->make(BoardDataService::class))
            );
        }
    }
}
