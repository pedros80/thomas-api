<?php

declare(strict_types=1);

namespace Thomas\Boards\Providers\RealTimeTrains\Framework;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
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
        /** @var int $numRows */
        $numRows = Config::get('services.board.numRows');

        $this->app->bind(
            RealTimeTrainsService::class,
            fn (): RealTimeTrainsService => new RealTimeTrainsService(
                $this->app->make(Locations::class),
                $this->app->make(ServiceInformation::class),
                new RTTBoardMapper(),
                $numRows,
            )
        );
    }

    private function bindServiceInformationService(): void
    {
        if (App::environment('testing')) {
            $concrete = new MockServiceInformationService();
        } else {
            /** @var string $user */
            $user = Config::get('services.rtt.user');
            /** @var string $pass */
            $pass = Config::get('services.rtt.pass');

            $concrete = $this->factory->makeServiceInformationService($user, $pass);
        }

        $this->app->bind(ServiceInformation::class, fn (): ServiceInformation => $concrete);
    }

    private function bindLocationService(): void
    {
        if (App::environment('testing')) {
            $concrete = new MockLocationService();
        } else {
            /** @var string $user */
            $user = Config::get('services.rtt.user');
            /** @var string $pass */
            $pass = Config::get('services.rtt.pass');

            $concrete = $this->factory->makeLocationService($user, $pass);
        }

        $this->app->bind(Locations::class, fn (): Locations => $concrete);
    }
}
