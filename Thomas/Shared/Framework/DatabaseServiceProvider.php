<?php

declare(strict_types=1);

namespace Thomas\Shared\Framework;

use Aws\DynamoDb\DynamoDbClient;
use Aws\Sdk;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Yaml\Yaml;
use Thomas\Shared\Infrastructure\DynamoMigrations;
use Thomas\Shared\Infrastructure\YmlDatabaseConfigLoader;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->bindDynamoDbClient();

        if (app()->environment('local', 'testing')) {
            $this->bindDynamoMigrations();
            $this->bindDatabaseConfigLoader();
        }
    }

    private function bindDynamoDbClient(): void
    {
        $this->app->singleton(DynamoDbClient::class, function (): DynamoDbClient {
            $sdk = new Sdk([
                'endpoint'    => config('nosql.dynamo.host'),
                'region'      => config('nosql.dynamo.region'),
                'version'     => config('nosql.dynamo.version'),
                'credentials' => config('nosql.dynamo.credentials'),
            ]);

            return $sdk->createDynamoDb();
        });
    }

    private function bindDynamoMigrations(): void
    {
        $this->app->bind(DynamoMigrations::class, function () {
            return new DynamoMigrations($this->app->make(DynamoDbClient::class));
        });
    }

    private function bindDatabaseConfigLoader(): void
    {
        $this->app->bind(YmlDatabaseConfigLoader::class, function () {
            return new YmlDatabaseConfigLoader(
                Yaml::parse(File::get('./serverless/Tables.yml')),
                config('nosql.tables'),
            );
        });
    }
}
