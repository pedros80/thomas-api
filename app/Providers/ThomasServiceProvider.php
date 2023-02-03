<?php

namespace App\Providers;

use GuzzleHttp\Client;
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
use Thomas\News\Application\Queries\GetNewsHeadlines;
use Thomas\News\Domain\RSSReader;
use Thomas\News\Infrastructure\BBCRSSParser;
use Thomas\News\Infrastructure\HttpRSSReader;
use Thomas\News\Infrastructure\Queries\GetNewsHeadlinesBBCRSS;
use Thomas\Stations\Application\Queries\SearchStations;
use Thomas\Stations\Domain\StationService;
use Thomas\Stations\Infrastructure\ArrayStationService;

final class ThomasServiceProvider extends ServiceProvider
{
    private ServicesFactory $factory;

    public function register(): void
    {
        $this->factory = new ServicesFactory();
        $this->bindLDB();
        $this->bindBoardClient();
        $this->bindBoardService();
        $this->bindBoardQueries();
        $this->bindStationService();
        $this->bindStationQueries();
        $this->bindRSS();
        $this->bindNewsQueries();
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
        $this->app->bind(
            GetStationBoardArrivals::class,
            fn () => new GetStationBoardArrivals($this->app->make(BoardService::class))
        );
        $this->app->bind(
            GetStationBoardDepartures::class,
            fn () => new GetStationBoardDepartures($this->app->make(BoardService::class))
        );
        $this->app->bind(
            GetPlatformBoardDepartures::class,
            fn () => new GetPlatformBoardDepartures($this->app->make(BoardService::class))
        );
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

    private function bindRSS(): void
    {
        $this->app->bind(
            RSSReader::class,
            fn () => new HttpRSSReader(
                new Client([
                    'headers' => [
                        'User-Agent' => 'Thomas Rss Reader',
                        'Accept'     => 'application/xml',
                    ],
                    'base_uri' => config('services.rss.bbc.url'),
                ]),
                new BBCRSSParser()
            )
        );

        $this->app->bind(
            GetNewsHeadlinesBBCRSS::class,
            fn () => new GetNewsHeadlinesBBCRSS($this->app->make(RSSReader::class))
        );
    }

    private function bindNewsQueries(): void
    {
        $this->app->bind(
            GetNewsHeadlines::class,
            fn () => $this->app->make(GetNewsHeadlinesBBCRSS::class)
        );
    }
}
