<?php

namespace App\Console\Commands\Dynamo;

use Illuminate\Console\Command;
use Thomas\Shared\Infrastructure\DynamoMigrations;
use Thomas\Shared\Infrastructure\YmlDatabaseConfigLoader;

final class SetupDynamo extends Command
{
    protected $signature   = 'dynamo:setup {do=prepare-tests : what to do?} {--confirm : really...}';
    protected $description = 'Setup the Dynamo tables';

    public function __construct(
        private DynamoMigrations $migrations,
        private YmlDatabaseConfigLoader $dbConfig,
    ) {
        parent::__construct();

        if (!app()->environment('local', 'testing')) {
            $this->info('not in this environment...');

            return;
        }
    }

    public function handle(): void
    {
        if (
            $this->argument('do') === 'prepare-tests' &&
            ($this->option('confirm') || $this->confirm('Really replace Test DynamoDB tables and seed?'))
        ) {
            $this->dropTestTables();
            $this->addTables();
        } elseif (
            $this->argument('do') === 'reset' &&
            ($this->option('confirm') || $this->confirm('Really drop all DynamoDB tables?'))
        ) {
            $this->dropTables();
            $this->addTables();
        } elseif (
            $this->argument('do') === 'add' &&
            ($this->option('confirm') || $this->confirm('Really add all DynamoDB tables?'))
        ) {
            $this->addTables();
        }
    }

    private function dropTables(): void
    {
        $dropped = $this->migrations->dropAllTables();
        $this->info("Dropped {$dropped} tables.");
    }

    private function dropTestTables(): void
    {
        $dropped = $this->migrations->dropTestTables();
        $this->info("Dropped {$dropped} tables.");
    }

    private function addTables(): void
    {
        array_map(function (array $tableConfig) {
            $status = $this->migrations->createTableIfNotExists($tableConfig);
            $this->info("{$tableConfig['TableName']}: {$status}");
        }, $this->dbConfig->getTableDefinitions());
    }
}
