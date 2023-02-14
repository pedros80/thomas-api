<?php

namespace Thomas\Users\Framework;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Illuminate\Support\ServiceProvider;
use Thomas\Shared\Application\CommandBus;
use Thomas\Users\Application\Commands\Handlers\RegisterUserCommandHandler;
use Thomas\Users\Application\Commands\Handlers\VerifyUserCommandHandler;
use Thomas\Users\Application\Queries\GetEmailFromUserIdAndVerifyToken;
use Thomas\Users\Domain\UsersRepository;
use Thomas\Users\Infrastructure\BroadwayRepository;
use Thomas\Users\Infrastructure\Projections\UserWasRegisteredProjection;
use Thomas\Users\Infrastructure\Projections\UserWasVerifiedProjection;
use Thomas\Users\Infrastructure\Queries\DynamoDbGetEmailFromUserIdAndVerifyToken;

final class UsersServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->bindUsersRepo();
        $this->bindAndSubscribeCommandHandlers();
        $this->subscribeEventListeners();
        $this->bindQueries();
    }

    private function bindQueries(): void
    {
        $this->app->bind(
            GetEmailFromUserIdAndVerifyToken::class,
            fn () => new DynamoDbGetEmailFromUserIdAndVerifyToken(
                $this->app->make(DynamoDbClient::class),
                $this->app->make(Marshaler::class),
                config('nosql.tables.thomas_table')
            )
        );
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
            RegisterUserCommandHandler::class,
            VerifyUserCommandHandler::class,
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
            UserWasRegisteredProjection::class,
            UserWasVerifiedProjection::class,
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
