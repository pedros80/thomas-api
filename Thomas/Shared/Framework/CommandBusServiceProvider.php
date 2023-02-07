<?php

declare(strict_types=1);

namespace Thomas\Shared\Framework;

use Broadway\CommandHandling\SimpleCommandBus;
use Illuminate\Support\ServiceProvider;
use Thomas\Shared\Application\Command;
use Thomas\Shared\Application\CommandBus;
use Thomas\Shared\Application\CommandHandler;

final class CommandBusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CommandBus::class, function (): CommandBus {

            return new class (new SimpleCommandBus()) implements CommandBus
            {
                public function __construct(
                    private SimpleCommandBus $bus
                ) {
                }

                public function dispatch(Command $command): void
                {
                    $this->bus->dispatch($command);
                }

                public function subscribe(CommandHandler $commandHandler): void
                {
                    $this->bus->subscribe($commandHandler);
                }
            };
        });
    }
}
