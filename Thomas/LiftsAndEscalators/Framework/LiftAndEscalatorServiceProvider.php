<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Framework;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Pedros80\LANDEphp\Contracts\LiftsAndEscalators;
use Pedros80\LANDEphp\Contracts\Tokens;
use Pedros80\LANDEphp\Factories\ServicesFactory;
use Tests\Mocks\Pedros80\LANDEphp\Services\MockLiftAndEscalatorService;
use Tests\Mocks\Pedros80\LANDEphp\Services\MockTokenGenerator;
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
        if (App::environment('testing')) {
            $concrete = new MockLiftAndEscalatorService();
        } else {
            /** @var string $key */
            $key = Config::get('services.lande.key');

            $concrete = $this->factory->makeLiftAndEscalatorService($key);
        }

        $this->app->bind(LiftsAndEscalators::class, fn (): LiftsAndEscalators => $concrete);
    }

    private function bindTokenGenerator(): void
    {
        if (App::environment('testing')) {
            $concrete = new MockTokenGenerator();
        } else {
            /** @var string $key */
            $key = Config::get('services.lande.key');

            $concrete = $this->factory->makeTokenGenerator($key);
        }

        $this->app->bind(Tokens::class, fn (): Tokens => $concrete);
    }

    private function bindTokenService(): void
    {
        $this->app->bind(
            TokenService::class,
            fn (): TokenService => $this->app->make(HttpTokenService::class)
        );
    }

    private function bindLiftAndEscalatorClient(): void
    {
        $this->app->bind(
            LiftAndEscalatorClient::class,
            fn (): LiftAndEscalatorClient => $this->app->make(HttpLiftAndEscalatorClient::class)
        );
    }
}
