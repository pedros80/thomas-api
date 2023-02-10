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
                    private SimpleCommandBus $bus,
                    private Logger $logger
                ) {
                }

                public function dispatch(Command $command): void
                {
                    /** @var string $log */
                    $log = json_encode($command);
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
