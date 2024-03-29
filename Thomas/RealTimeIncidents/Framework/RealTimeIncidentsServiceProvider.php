<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Framework;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Illuminate\Support\ServiceProvider;
use Pedros80\NREphp\Services\RealTimeIncidentsBroker;
use Thomas\RealTimeIncidents\Application\Commands\Converters\ModifiedMessageToCommand;
use Thomas\RealTimeIncidents\Application\Commands\Converters\NewMessageToCommand;
use Thomas\RealTimeIncidents\Application\Commands\Converters\RemovedMessageToCommand;
use Thomas\RealTimeIncidents\Application\Commands\Handlers\AddIncidentCommandHandler;
use Thomas\RealTimeIncidents\Application\Commands\Handlers\RemoveIncidentCommandHandler;
use Thomas\RealTimeIncidents\Application\Commands\Handlers\UpdateIncidentCommandHandler;
use Thomas\RealTimeIncidents\Application\Commands\RTICommandFactory;
use Thomas\RealTimeIncidents\Application\Queries\GetIncidents;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;
use Thomas\RealTimeIncidents\Domain\IncidentsRepository;
use Thomas\RealTimeIncidents\Infrastructure\BroadwayRepository;
use Thomas\RealTimeIncidents\Infrastructure\Projections\IncidentWasAddedProjection;
use Thomas\RealTimeIncidents\Infrastructure\Projections\IncidentWasRemovedProjection;
use Thomas\RealTimeIncidents\Infrastructure\Projections\IncidentWasUpdatedProjection;
use Thomas\RealTimeIncidents\Infrastructure\Queries\DynamoDbGetIncidents;
use Thomas\Shared\Application\CommandBus;

final class RealTimeIncidentsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->bindRealTimeIncidentsBroker();
        $this->bindIncidentsRepository();
        $this->bindAndSubscribeCommandHandlers();
        $this->subscribeEventListeners();
        $this->bindQueries();
        $this->bindRTICommandFactory();
    }

    private function bindRTICommandFactory(): void
    {
        $this->app->bind(
            RTICommandFactory::class,
            fn () => new RTICommandFactory([
                IncidentMessageStatus::NEW      => new NewMessageToCommand(),
                IncidentMessageStatus::MODIFIED => new ModifiedMessageToCommand(),
                IncidentMessageStatus::REMOVED  => new RemovedMessageToCommand(),
            ])
        );
    }

    private function bindQueries(): void
    {
        $queries = [
            GetIncidents::class => DynamoDbGetIncidents::class,
        ];

        foreach ($queries as $interface => $concrete) {
            $this->app->bind(
                $interface,
                fn () => new $concrete(
                    $this->app->make(DynamoDbClient::class),
                    $this->app->make(Marshaler::class),
                    config('nosql.tables.thomas_table')
                )
            );
        }
    }

    private function bindRealTimeIncidentsBroker(): void
    {
        $this->app->bind(
            RealTimeIncidentsBroker::class,
            fn () => RealTimeIncidentsBroker::fromCredentials(
                config('services.nre.kbrti.user'),
                config('services.nre.kbrti.pass')
            )
        );
    }

    private function bindIncidentsRepository(): void
    {
        $this->app->bind(
            IncidentsRepository::class,
            fn () => new BroadwayRepository(
                $this->app->make(EventStore::class),
                $this->app->make(EventBus::class)
            )
        );
    }

    private function subscribeEventListeners(): void
    {
        $listener = [
            IncidentWasAddedProjection::class,
            IncidentWasUpdatedProjection::class,
            IncidentWasRemovedProjection::class,
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

    private function bindAndSubscribeCommandHandlers(): void
    {
        $handlers = [
            AddIncidentCommandHandler::class,
            UpdateIncidentCommandHandler::class,
            RemoveIncidentCommandHandler::class,
        ];

        /** @var CommandBus $commandBus */
        $commandBus = $this->app->get(CommandBus::class);

        foreach ($handlers as $handler) {
            $this->app->bind(
                $handler,
                fn () => new $handler($this->app->make(IncidentsRepository::class))
            );
            $commandBus->subscribe($this->app->make($handler));
        }
    }
}
