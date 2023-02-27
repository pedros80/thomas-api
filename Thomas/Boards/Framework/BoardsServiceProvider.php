<?php

declare(strict_types=1);

namespace Thomas\Boards\Framework;

use Illuminate\Support\ServiceProvider;
use Pedros80\NREphp\Factories\ServicesFactory;
use Pedros80\NREphp\Services\LiveDepartureBoard;
use Thomas\Boards\Application\Queries\GetPlatformBoardDepartures;
use Thomas\Boards\Application\Queries\GetStationBoardArrivals;
use Thomas\Boards\Application\Queries\GetStationBoardDepartures;
use Thomas\Boards\Domain\BoardClient;
use Thomas\Boards\Domain\BoardService;
use Thomas\Boards\Infrastructure\HttpBoardClient;
use Thomas\Boards\Infrastructure\HttpBoardService;

final class BoardsServiceProvider extends ServiceProvider
{
    private ServicesFactory $factory;

    public function register(): void
    {
        $this->factory = new ServicesFactory();
        $this->bindLDB();
        $this->bindBoardClient();
        $this->bindBoardService();
        $this->bindBoardQueries();
    }

    private function bindLDB(): void
    {
        $this->app->bind(
            LiveDepartureBoard::class,
            fn () => $this->factory->makeLiveDepartureBoard(config('services.nre.ldb.key'))
        );
    }

    private function bindBoardClient(): void
    {
        $this->app->bind(
            BoardClient::class,
            fn () => new HttpBoardClient($this->app->make(LiveDepartureBoard::class))
        );
    }

    private function bindBoardService(): void
    {
        $this->app->bind(
            BoardService::class,
            fn () => new HttpBoardService(
                $this->app->make(BoardClient::class),
                config('services.nre.ldb.numRows')
            )
        );
    }

    private function bindBoardQueries(): void
    {
        $queries = [
            GetStationBoardArrivals::class,
            GetStationBoardDepartures::class,
            GetPlatformBoardDepartures::class,
        ];

        foreach ($queries as $query) {
            $this->app->bind(
                $query,
                fn () => new $query($this->app->make(BoardService::class))
            );
        }
    }
}
