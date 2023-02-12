<?php

namespace Thomas\Shared\Framework;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Broadway\EventHandling\EventBus;
use Broadway\EventHandling\SimpleEventBus;
use Broadway\EventStore\EventStore;
use Illuminate\Support\ServiceProvider;
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

        $this->app->singleton(EventBus::class, fn () => new SimpleEventBus());
    }
}
