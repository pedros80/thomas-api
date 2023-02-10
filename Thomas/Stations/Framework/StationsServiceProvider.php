<?php

namespace Thomas\Stations\Framework;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Illuminate\Support\ServiceProvider;
use Thomas\Shared\Application\CommandBus;
use Thomas\Stations\Application\Commands\Handlers\RecordStationMessageCommandHandler;
use Thomas\Stations\Application\Commands\Handlers\RemoveStationMessageCommandHandler;
use Thomas\Stations\Application\Queries\GetStationMessages;
use Thomas\Stations\Application\Queries\SearchStations;
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
        $this->bindStationQueries();
        $this->bindMessagesRepository();
        $this->bindAndSubscribeCommandHandlers();
        $this->subscribeEventListeners();
        $this->bindQueries();
    }

    private function bindQueries(): void
    {
        $this->app->bind(
            GetStationMessages::class,
            fn () => new DynamoDbGetStationMessages(
                $this->app->make(DynamoDbClient::class),
                $this->app->make(Marshaler::class),
                config('nosql.tables.thomas_table')
            )
        );
    }

    private function bindMessagesRepository(): void
    {
        $this->app->bind(
            MessagesRepository::class,
            fn () => new BroadwayRepository(
                $this->app->make(EventStore::class),
                $this->app->make(EventBus::class)
            )
        );
    }

    private function bindStationService(): void
    {
        $this->app->bind(
            StationService::class,
            fn () => new ArrayStationService()
        );
    }

    private function bindStationQueries(): void
    {
        $this->app->bind(
            SearchStations::class,
            fn () => new SearchStations($this->app->make(StationService::class))
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
