<?php

declare(strict_types=1);

namespace Thomas\Boards\Framework;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Thomas\Boards\Domain\BoardDataService;
use Thomas\Boards\Providers\NationalRailEnquiries\NationalRailEnquiriesService;
use Thomas\Boards\Providers\RealTimeTrains\RealTimeTrainsService;

final class BoardsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->bindBoardDataService();
    }

    private function bindBoardDataService(): void
    {
        switch (Config::get('services.board.provider')) {
            case 'rtt':
                $this->app->bind(
                    BoardDataService::class,
                    fn (): BoardDataService => $this->app->make(RealTimeTrainsService::class)
                );

                break;

            default:
                $this->app->bind(
                    BoardDataService::class,
                    fn (): BoardDataService => $this->app->make(NationalRailEnquiriesService::class)
                );

                break;
        }
    }
}
