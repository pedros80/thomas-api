<?php

namespace Thomas\Shared\Framework;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Broadway\Domain\DomainEventStream;
use Broadway\EventHandling\EventListener;
use Broadway\EventHandling\SimpleEventBus;
use Illuminate\Support\ServiceProvider;
use Thomas\Shared\Domain\EventBus;
use Thomas\Shared\Domain\EventStore;
use Thomas\Shared\Infrastructure\DynamoDbEventStore;

class EventSourcingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(EventStore::class, function ($app) {
            return new DynamoDbEventStore(
                $app->make(DynamoDbClient::class),
                $app->make(Marshaler::class),
                config('nosql.tables.event_store_table')
            );
        });

        $this->app->singleton(EventBus::class, function () {
            return new class (new SimpleEventBus()) implements EventBus {
                public function __construct(
                    private SimpleEventBus $bus
                ) {
                }

                public function subscribe(EventListener $eventListener): void
                {
                    $this->bus->subscribe($eventListener);
                }

                public function publish(DomainEventStream $domainMessages): void
                {
                    $this->bus->publish($domainMessages);
                }
            };
        });
    }
}
