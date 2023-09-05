<?php

declare(strict_types=1);

namespace Thomas\Boards\Providers\RealTimeTrains\Framework;

use Illuminate\Support\ServiceProvider;
use Pedros80\RTTphp\Contracts\Locations;
use Pedros80\RTTphp\Contracts\ServiceInformation;
use Pedros80\RTTphp\Factories\ServicesFactory;
use Tests\Mocks\Pedros80\RTTphp\Services\MockLocationService;
use Tests\Mocks\Pedros80\RTTphp\Services\MockServiceInformationService;
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
                $this->app->make(Locations::class),
                $this->app->make(ServiceInformation::class),
                new RTTBoardMapper(),
                config('services.board.numRows'),
            )
        );
    }

    private function bindServiceInformationService(): void
    {
        $concrete = config('app.env') === 'testing' ? new MockServiceInformationService() :
            $this->factory->makeServiceInformationService(
                config('services.rtt.user'),
                config('services.rtt.pass')
            );

        $this->app->bind(ServiceInformation::class, fn () => $concrete);
    }

    private function bindLocationService(): void
    {
        $concrete = config('app.env') === 'testing' ? new MockLocationService() :
            $this->factory->makeLocationService(
                config('services.rtt.user'),
                config('services.rtt.pass')
            );

        $this->app->bind(Locations::class, fn () => $concrete);
    }
}
