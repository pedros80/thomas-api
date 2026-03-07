<?php

declare(strict_types=1);

namespace Thomas\Boards\Providers\NationalRailEnquiries\Framework;

use Illuminate\Support\Facades\Config;
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
        /** @var string $key */
        $key = Config::get('services.nre.ldb.key');

        $concrete = Config::get('app.env') === 'testing' ? new MockLiveDepartureBoard() :
            $this->factory->makeLiveDepartureBoard($key);

        $this->app->bind(
            Boards::class,
            fn (): Boards => $concrete
        );
    }

    private function bindNationalRailEnquiriesService(): void
    {
        /** @var int $numRows */
        $numRows = Config::get('services.board.numRows');

        $this->app->bind(
            NationalRailEnquiriesService::class,
            fn (): NationalRailEnquiriesService => new NationalRailEnquiriesService(
                $this->app->make(Boards::class),
                new NREBoardMapper(),
                $numRows
            )
        );
    }
}
