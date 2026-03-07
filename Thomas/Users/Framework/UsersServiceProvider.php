<?php

declare(strict_types=1);

namespace Thomas\Users\Framework;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Broadway\EventHandling\EventBus;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Thomas\Shared\Application\CommandBus;
use Thomas\Users\Application\Commands\Handlers\AddUserCommandHandler;
use Thomas\Users\Application\Commands\Handlers\RemoveUserCommandHandler;
use Thomas\Users\Domain\UsersRepository;
use Thomas\Users\Infrastructure\BroadwayRepository;
use Thomas\Users\Infrastructure\Projections\UserWasAddedProjection;
use Thomas\Users\Infrastructure\Projections\UserWasReinstatedProjection;
use Thomas\Users\Infrastructure\Projections\UserWasRemovedProjection;
use Thomas\Users\Infrastructure\UserResolver;

final class UsersServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->bindUsersRepo();
        $this->bindAndSubscribeCommandHandlers();
        $this->subscribeEventListeners();
        $this->bindUserResolver();
    }

    private function bindUserResolver(): void
    {
        /** @var string $secret */
        $secret = Config::get('jwt.secret');
        /** @var string $algo */
        $algo = Config::get('jwt.algo');

        $this->app->bind(
            UserResolver::class,
            fn (): UserResolver => new UserResolver(
                $this->app->make(UsersRepository::class),
                $secret,
                $algo,
            )
        );
    }

    private function bindUsersRepo(): void
    {
        $this->app->bind(
            UsersRepository::class,
            fn (): UsersRepository => $this->app->make(BroadwayRepository::class)
        );
    }

    private function bindAndSubscribeCommandHandlers(): void
    {
        $handlers = [
            AddUserCommandHandler::class,
            RemoveUserCommandHandler::class,
        ];

        /** @var CommandBus $commandBus */
        $commandBus = $this->app->get(CommandBus::class);

        foreach ($handlers as $handler) {
            $this->app->bind(
                $handler,
                fn () => new $handler($this->app->make(UsersRepository::class))
            );
            $commandBus->subscribe($this->app->make($handler));
        }
    }

    private function subscribeEventListeners(): void
    {
        $listener = [
            UserWasAddedProjection::class,
            UserWasRemovedProjection::class,
            UserWasReinstatedProjection::class,
        ];

        /** @var string $table */
        $table = Config::get('nosql.tables.thomas_table');

        /** @var EventBus $eventBus */
        $eventBus = $this->app->get(EventBus::class);
        array_map(function (string $listener) use ($eventBus, $table) {
            $this->app->bind(
                $listener,
                fn () => new $listener(
                    $this->app->make(DynamoDbClient::class),
                    $this->app->make(Marshaler::class),
                    $table
                )
            );
            $eventBus->subscribe($this->app->make($listener));
        }, $listener);
    }
}
