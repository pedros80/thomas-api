<?php

declare(strict_types=1);

namespace Thomas\Stations\Framework;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Broadway\EventHandling\EventBus;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Thomas\Shared\Application\CommandBus;
use Thomas\Stations\Application\Commands\Handlers\RecordStationMessageCommandHandler;
use Thomas\Stations\Application\Commands\Handlers\RemoveStationMessageCommandHandler;
use Thomas\Stations\Application\Queries\GetStationMessages;
use Thomas\Stations\Domain\MessagesRepository;
use Thomas\Stations\Domain\StationService;
use Thomas\Stations\Infrastructure\ArrayStationService;
use Thomas\Stations\Infrastructure\BroadwayRepository;
use Thomas\Stations\Infrastructure\Projections\MessageWasAddedProjection;
use Thomas\Stations\Infrastructure\Projections\MessageWasRemovedProjection;
use Thomas\Stations\Infrastructure\Projections\MessageWasUpdatedProjection;
use Thomas\Stations\Infrastructure\Queries\DynamoDbGetStationMessages;

final class StationsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->bindStationService();
        $this->bindMessagesRepository();
        $this->bindAndSubscribeCommandHandlers();
        $this->subscribeEventListeners();
        $this->bindQueries();
    }

    private function bindQueries(): void
    {
        /** @var string $table */
        $table = Config::get('nosql.tables.thomas_table');

        $this->app->bind(
            GetStationMessages::class,
            fn (): GetStationMessages => new DynamoDbGetStationMessages(
                $this->app->make(DynamoDbClient::class),
                $this->app->make(Marshaler::class),
                $table
            )
        );
    }

    private function bindMessagesRepository(): void
    {
        $this->app->bind(
            MessagesRepository::class,
            fn (): MessagesRepository => $this->app->make(BroadwayRepository::class)
        );
    }

    private function bindStationService(): void
    {
        $this->app->bind(
            StationService::class,
            fn (): StationService => new ArrayStationService()
        );
    }

    private function bindAndSubscribeCommandHandlers(): void
    {
        $handlers = [
            RecordStationMessageCommandHandler::class,
            RemoveStationMessageCommandHandler::class,
        ];

        /** @var CommandBus $commandBus */
        $commandBus = $this->app->get(CommandBus::class);

        foreach ($handlers as $handler) {
            $this->app->bind(
                $handler,
                fn () => new $handler($this->app->make(MessagesRepository::class))
            );
            $commandBus->subscribe($this->app->make($handler));
        }
    }

    private function subscribeEventListeners(): void
    {
        $listener = [
            MessageWasAddedProjection::class,
            MessageWasUpdatedProjection::class,
            MessageWasRemovedProjection::class,
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
