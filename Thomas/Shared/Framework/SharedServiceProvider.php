<?php

declare(strict_types=1);

namespace Thomas\Shared\Framework;

use Illuminate\Support\ServiceProvider;
use Pedros80\NREphp\Factories\ServicesFactory;
use Pedros80\NREphp\Services\KnowledgeBase;
use Pedros80\NREphp\Services\PushPortBroker;
use Pedros80\NREphp\Services\TokenGenerator;
use Thomas\Shared\Application\DarwinCommandFactory;
use Thomas\Shared\Domain\KBService;
use Thomas\Shared\Domain\TokenService;
use Thomas\Shared\Infrastructure\HttpKBService;
use Thomas\Shared\Infrastructure\HttpTokenService;
use Thomas\Stations\Application\Commands\StationMessageToCommand;

final class SharedServiceProvider extends ServiceProvider
{
    private ServicesFactory $factory;

    public function register(): void
    {
        $this->factory = new ServicesFactory();
        $this->bindKB();
        $this->bindKBService();
        $this->bindTokenGenerator();
        $this->bindTokenService();
        $this->bindPushPortBroker();
        $this->bindDarwinCommandFactory();
    }

    private function bindDarwinCommandFactory(): void
    {
        $this->app->bind(
            DarwinCommandFactory::class,
            fn () => new DarwinCommandFactory([
                'OW' => new StationMessageToCommand(),
            ])
        );
    }

    private function bindPushPortBroker(): void
    {
        $this->app->bind(
            PushPortBroker::class,
            fn () => PushPortBroker::fromCredentials(
                config('services.nre.darwin.user'),
                config('services.nre.darwin.pass')
            )
        );
    }

    private function bindKBService(): void
    {
        $this->app->bind(
            KBService::class,
            fn () => new HttpKBService(
                $this->app->make(TokenService::class),
                $this->app->make(KnowledgeBase::class)
            )
        );
    }

    private function bindKB(): void
    {
        $this->app->bind(
            KnowledgeBase::class,
            fn () => $this->factory->makeKnowledgeBase()
        );
    }

    private function bindTokenService(): void
    {
        $this->app->bind(
            TokenService::class,
            fn () => new HttpTokenService($this->app->make(TokenGenerator::class))
        );
    }

    private function bindTokenGenerator(): void
    {
        $this->app->bind(
            TokenGenerator::class,
            fn () => $this->factory->makeTokenGenerator(
                config('services.nre.kb.user'),
                config('services.nre.kb.pass')
            )
        );
    }
}
