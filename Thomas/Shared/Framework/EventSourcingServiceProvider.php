<?php

declare(strict_types=1);

namespace Thomas\Shared\Framework;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Broadway\EventHandling\EventBus;
use Broadway\EventHandling\SimpleEventBus;
use Broadway\EventStore\EventStore;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Thomas\Shared\Infrastructure\DynamoDbEventStore;

class EventSourcingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        /** @var string $table */
        $table = Config::get('nosql.tables.event_store_table');

        $this->app->singleton(
            EventStore::class,
            fn (): EventStore => new DynamoDbEventStore(
                $this->app->make(DynamoDbClient::class),
                $this->app->make(Marshaler::class),
                $table,
            )
        );

        $this->app->singleton(EventBus::class, fn (): EventBus => new SimpleEventBus());
    }
}
