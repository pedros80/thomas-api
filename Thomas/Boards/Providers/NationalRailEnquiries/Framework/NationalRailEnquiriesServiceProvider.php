<?php

declare(strict_types=1);

namespace Thomas\Boards\Providers\NationalRailEnquiries\Framework;

use Illuminate\Support\ServiceProvider;
use Pedros80\NREphp\Contracts\Boards;
use Pedros80\NREphp\Factories\ServicesFactory;
use Tests\Mocks\Pedros80\NREphp\Services\MockLiveDepartureBoard;
use Thomas\Boards\Providers\NationalRailEnquiries\NationalRailEnquiriesService;
use Thomas\Boards\Providers\NationalRailEnquiries\NREBoardMapper;

final class NationalRailEnquiriesServiceProvider extends ServiceProvider
{
    private ServicesFactory $factory;

    public function register(): void
    {
        $this->factory = new ServicesFactory();
        $this->bindBoards();
        $this->bindNationalRailEnquiriesService();
    }

    private function bindBoards(): void
    {
        $concrete = config('app.env') === 'testing' ? new MockLiveDepartureBoard() :
            $this->factory->makeLiveDepartureBoard(config('services.nre.ldb.key'));

        $this->app->bind(
            Boards::class,
            fn () => $concrete
        );
    }

    private function bindNationalRailEnquiriesService(): void
    {
        $this->app->bind(
            NationalRailEnquiriesService::class,
            fn () => new NationalRailEnquiriesService(
                $this->app->make(Boards::class),
                new NREBoardMapper(),
                config('services.board.numRows')
            )
        );
    }
}
