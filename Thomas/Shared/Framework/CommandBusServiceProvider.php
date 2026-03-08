<?php

declare(strict_types=1);

namespace Thomas\Shared\Framework;

use Broadway\CommandHandling\SimpleCommandBus;
use Illuminate\Log\Logger;
use Illuminate\Support\ServiceProvider;
use Thomas\Shared\Application\Command;
use Thomas\Shared\Application\CommandBus;
use Thomas\Shared\Application\CommandHandler;

final class CommandBusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CommandBus::class, function (): CommandBus {
            return new class(new SimpleCommandBus(), $this->app->make(Logger::class)) implements CommandBus {
                public function __construct(
                    private readonly SimpleCommandBus $bus,
                    private readonly Logger $logger,
                ) {
                }

                public function dispatch(Command $command): void
                {
                    $log = json_encode($command, JSON_THROW_ON_ERROR);
                    $this->logger->info($log);

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
