<?php

declare(strict_types=1);

namespace Thomas\Boards\Providers\RealTimeTrains\Framework;

use Illuminate\Support\ServiceProvider;
use Pedros80\RTTphp\Factories\ServicesFactory;
use Pedros80\RTTphp\Services\LocationService;
use Pedros80\RTTphp\Services\ServiceInformationService;
use Thomas\Boards\Providers\RealTimeTrains\RealTimeTrainsService;
use Thomas\Boards\Providers\RealTimeTrains\RTTBoardMapper;

final class RealTimeTrainsServiceProvider extends ServiceProvider
{
    private ServicesFactory $factory;

    public function register(): void
    {
        $this->factory = new ServicesFactory();
        $this->bindLocationService();
        $this->bindServiceInformationService();
        $this->bindRealTimeTrainsService();
    }

    private function bindRealTimeTrainsService(): void
    {
        $this->app->bind(
            RealTimeTrainsService::class,
            fn () => new RealTimeTrainsService(
                $this->app->make(LocationService::class),
                $this->app->make(ServiceInformationService::class),
                new RTTBoardMapper(),
                config('services.board.numRows'),
            )
        );
    }

    private function bindLocationService(): void
    {
        $this->app->bind(
            LocationService::class,
            fn () => $this->factory->makeLocationService(
                config('services.rtt.user'),
                config('services.rtt.pass')
            )
        );
    }

    private function bindServiceInformationService(): void
    {
        $this->app->bind(
            ServiceInformationService::class,
            fn () => $this->factory->makeServiceInformationService(
                config('services.rtt.user'),
                config('services.rtt.pass')
            )
        );
    }
}
