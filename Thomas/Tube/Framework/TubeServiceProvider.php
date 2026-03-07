<?php

declare(strict_types=1);

namespace Thomas\Tube\Framework;

use Illuminate\Cache\Repository;
use Illuminate\Support\ServiceProvider;
use Thomas\Tube\Application\Queries\GetNaptansByLine;
use Thomas\Tube\Domain\TubeService;
use Thomas\Tube\Providers\TfL\TfLService;

final class TubeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->bindService();
        $this->bindTubeQueries();
    }

    private function bindService(): void
    {
        $this->app->bind(
            TubeService::class,
            fn (): TubeService => $this->app->make(TfLService::class),
        );
    }

    private function bindTubeQueries(): void
    {
        $this->app->bind(
            GetNaptansByLine::class,
            fn (): GetNaptansByLine => new GetNaptansByLine(
                $this->app->make(TubeService::class),
                $this->app->make(Repository::class),
            )
        );
    }
}
