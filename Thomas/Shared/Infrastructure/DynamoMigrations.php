<?php

namespace Thomas\Shared\Infrastructure;

use Aws\DynamoDb\DynamoDbClient;

final class DynamoMigrations
{
    public function __construct(
        private DynamoDbClient $dynamo
    ) {
    }

    public function dropAllTables(): string
    {
        $tableNames = $this->dynamo->listTables([])['TableNames'];

        if (!$tableNames) {
            return 'no';
        }

        return $this->dropTables($tableNames);
    }

    public function dropTestTables(): string
    {
        $tableNames = array_filter(
            $this->dynamo->listTables([])['TableNames'],
            fn (string $name) => str_starts_with($name, 'Test')
        );

        if (!$tableNames) {
            return 'no';
        }

        return $this->dropTables($tableNames);
    }

    private function dropTables(array $tables): string
    {
        return implode(', ', array_map(function ($table) {
            $this->dynamo->deleteTable(['TableName' => $table]);

            return $table;
        }, $tables));
    }

    public function createTableIfNotExists(array $tableConfig): string
    {
        if ($this->checkIfTableExists($tableConfig['TableName'])) {
            return 'Existed';
        }

        $this->createTable($tableConfig);
        $this->updateTableTTL($tableConfig);

        return 'Created';
    }

    private function checkIfTableExists(string $tableName): bool
    {
        $result = $this->dynamo->listTables([]);

        return in_array($tableName, $result['TableNames']);
    }

    private function createTable(array $tableConfig): void
    {
        $this->dynamo->createTable($tableConfig);
    }

    private function updateTableTTL(array $tableConfig): void
    {
        if (!array_key_exists('TimeToLiveSpecification', $tableConfig)) {
            return;
        }

        $this->dynamo->updateTimeToLive([
            'TableName'               => $tableConfig['TableName'],
            'TimeToLiveSpecification' => [
                'AttributeName' => $tableConfig['TimeToLiveSpecification']['AttributeName'],
                'Enabled'       => true,
            ],
        ]);
    }
}
