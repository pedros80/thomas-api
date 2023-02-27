<?php

declare(strict_types=1);

namespace Thomas\ServiceIndicator\Framework;

use Illuminate\Support\ServiceProvider;
use Thomas\ServiceIndicator\Application\Queries\GetServiceIndicators;
use Thomas\ServiceIndicator\Domain\ServiceIndicatorService;
use Thomas\ServiceIndicator\Infrastructure\HttpServiceIndicatorService;
use Thomas\ServiceIndicator\Infrastructure\ServiceIndicatorParser;
use Thomas\Shared\Domain\KBService;

final class ServiceIndicatorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->bindServiceIndicatorService();
        $this->bindServiceIndicatorQueries();
    }

    private function bindServiceIndicatorQueries(): void
    {
        $this->app->bind(
            GetServiceIndicators::class,
            fn () => new GetServiceIndicators(
                $this->app->make(ServiceIndicatorService::class)
            )
        );
    }

    private function bindServiceIndicatorService(): void
    {
        $this->app->bind(
            ServiceIndicatorService::class,
            fn () => new HttpServiceIndicatorService(
                $this->app->make(KBService::class),
                new ServiceIndicatorParser()
            )
        );
    }
}
