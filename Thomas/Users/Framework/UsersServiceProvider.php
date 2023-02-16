<?php

namespace Thomas\Users\Framework;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Illuminate\Support\ServiceProvider;
use Thomas\Shared\Application\CommandBus;
use Thomas\Users\Application\Commands\Handlers\AddUserCommandHandler;
use Thomas\Users\Domain\UsersRepository;
use Thomas\Users\Infrastructure\BroadwayRepository;
use Thomas\Users\Infrastructure\Projections\UserWasAddedProjection;

final class UsersServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->bindUsersRepo();
        $this->bindAndSubscribeCommandHandlers();
        $this->subscribeEventListeners();
    }

    private function bindUsersRepo(): void
    {
        $this->app->bind(
            UsersRepository::class,
            fn () => new BroadwayRepository(
                $this->app->make(EventStore::class),
                $this->app->make(EventBus::class)
            )
        );
    }

    private function bindAndSubscribeCommandHandlers(): void
    {
        $handlers = [
            AddUserCommandHandler::class,
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
        ];

        $eventBus = $this->app->get(EventBus::class);
        array_map(function (string $listener) use ($eventBus) {
            $this->app->bind(
                $listener,
                fn () => new $listener(
                    $this->app->make(DynamoDbClient::class),
                    $this->app->make(Marshaler::class),
                    config('nosql.tables.thomas_table')
                )
            );
            $eventBus->subscribe($this->app->make($listener));
        }, $listener);
    }
}
