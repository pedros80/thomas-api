<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Framework;

use Illuminate\Support\ServiceProvider;
use Pedros80\LANDEphp\Contracts\LiftsAndEscalators;
use Pedros80\LANDEphp\Contracts\Tokens;
use Pedros80\LANDEphp\Factories\ServicesFactory;
use Thomas\LiftsAndEscalators\Domain\LiftAndEscalatorClient;
use Thomas\LiftsAndEscalators\Domain\TokenService;
use Thomas\LiftsAndEscalators\Infrastructure\HttpLiftAndEscalatorClient;
use Thomas\LiftsAndEscalators\Infrastructure\HttpTokenService;

final class LiftAndEscalatorServiceProvider extends ServiceProvider
{
    private ServicesFactory $factory;

    public function register(): void
    {
        $this->factory = new ServicesFactory();
        $this->bindLiftsAndEscalators();
        $this->bindTokenGenerator();
        $this->bindTokenService();
        $this->bindLiftAndEscalatorClient();
    }

    private function bindLiftsAndEscalators(): void
    {
        $this->app->bind(
            LiftsAndEscalators::class,
            fn () => $this->factory->makeLiftAndEscalatorService(config('services.lande.key'))
        );
    }

    private function bindTokenGenerator(): void
    {
        $this->app->bind(
            Tokens::class,
            fn () => $this->factory->makeTokenGenerator(config('services.lande.key'))
        );
    }

    private function bindTokenService(): void
    {
        $this->app->bind(
            TokenService::class,
            fn () => new HttpTokenService($this->app->make(Tokens::class))
        );
    }

    private function bindLiftAndEscalatorClient(): void
    {
        $this->app->bind(
            LiftAndEscalatorClient::class,
            fn () => new HttpLiftAndEscalatorClient(
                $this->app->make(LiftsAndEscalators::class),
                $this->app->make(TokenService::class)
            )
        );
    }
}
