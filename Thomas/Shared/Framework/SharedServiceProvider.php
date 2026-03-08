<?php

declare(strict_types=1);

namespace Thomas\Shared\Framework;

use Illuminate\Support\Facades\Config;
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
            fn (): DarwinCommandFactory => new DarwinCommandFactory([
                'OW' => new StationMessageToCommand(),
            ]),
        );
    }

    private function bindPushPortBroker(): void
    {
        /** @var string $user */
        $user = Config::get('services.nre.darwin.user');
        /** @var string $pass */
        $pass = Config::get('services.nre.darwin.pass');

        $this->app->bind(
            PushPortBroker::class,
            fn (): PushPortBroker => PushPortBroker::fromCredentials($user, $pass)
        );
    }

    private function bindKBService(): void
    {
        $this->app->bind(
            KBService::class,
            fn (): KBService => new HttpKBService(
                $this->app->make(TokenService::class),
                $this->app->make(KnowledgeBase::class)
            )
        );
    }

    private function bindKB(): void
    {
        $this->app->bind(
            KnowledgeBase::class,
            fn (): KnowledgeBase => $this->factory->makeKnowledgeBase()
        );
    }

    private function bindTokenService(): void
    {
        $this->app->bind(
            TokenService::class,
            fn (): TokenService => new HttpTokenService($this->app->make(TokenGenerator::class))
        );
    }

    private function bindTokenGenerator(): void
    {
        /** @var string $user */
        $user = Config::get('services.nre.kb.user');
        /** @var string $pass */
        $pass = Config::get('services.nre.kb.pass');

        $this->app->bind(
            TokenGenerator::class,
            fn (): TokenGenerator => $this->factory->makeTokenGenerator($user, $pass)
        );
    }
}
