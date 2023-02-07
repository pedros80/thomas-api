<?php

namespace Thomas\Shared\Infrastructure;

final class YmlDatabaseConfigLoader
{
    public function __construct(
        private array $definitions,
        private array $tableNames,
    ) {
    }

    public function getTableDefinitions(): array
    {
        return array_reduce($this->definitions['Resources'], function ($defs, $def) {
            $name = $this->cleanTableName($def['Properties']['TableName']);

            if ($this->definitionExists($name)) {
                $defs[] = $this->getTableDefinition($name);
                $defs[] = $this->getTableDefinition("Test{$name}", $name);
            }

            return $defs;
        }, []);
    }

    private function definitionExists(string $tableDefinition): bool
    {
        return array_key_exists($tableDefinition, $this->definitions['Resources']);
    }

    private function getTableDefinition(string $tableName, ?string $tableDefinition = null): array
    {
        $tableDefinition = $tableDefinition ?: $tableName;
        $out             = [
            'TableName'              => $tableName,
            'KeySchema'              => $this->getKeySchema($tableDefinition),
            'AttributeDefinitions'   => $this->getAttributeDefinitions($tableDefinition),
            'ProvisionedThroughput'  => $this->getDummyProvisionedThroughput(),
        ];

        $secondaryIndexes = $this->getGlobalSecondaryIndexes($tableDefinition);
        if ($secondaryIndexes) {
            $out['GlobalSecondaryIndexes'] = $secondaryIndexes;
        }

        $ttl = $this->getTTL($tableDefinition);
        if ($ttl) {
            $out['TimeToLiveSpecification'] = $ttl;
        }

        return $out;
    }

    private function getKeySchema(string $tableDefinition): array
    {
        return array_map(fn (array $item) => [
            'AttributeName' => $item['AttributeName'],
            'KeyType'       => $item['KeyType'],
        ], $this->definitions['Resources'][$tableDefinition]['Properties']['KeySchema']);
    }

    private function getTTL(string $tableDefinition): array
    {
        if (!array_key_exists('TimeToLiveSpecification', $this->definitions['Resources'][$tableDefinition]['Properties'])) {
            return [];
        }

        return $this->definitions['Resources'][$tableDefinition]['Properties']['TimeToLiveSpecification'];
    }

    private function getAttributeDefinitions(string $tableDefinition): array
    {
        return array_map(fn (array $item) => [
            'AttributeName' => $item['AttributeName'],
            'AttributeType' => $item['AttributeType'],
        ], $this->definitions['Resources'][$tableDefinition]['Properties']['AttributeDefinitions']);
    }

    private function getGlobalSecondaryIndexes(string $tableDefinition): array
    {
        if (!array_key_exists('GlobalSecondaryIndexes', $this->definitions['Resources'][$tableDefinition]['Properties'])) {
            return [];
        }

        return array_map(fn (array $item) => [
            'IndexName'             => $item['IndexName'],
            'KeySchema'             => $item['KeySchema'],
            'Projection'            => $item['Projection'],
            'ProvisionedThroughput' => $this->getDummyProvisionedThroughput(),
        ], $this->definitions['Resources'][$tableDefinition]['Properties']['GlobalSecondaryIndexes']);
    }

    private function getDummyProvisionedThroughput(): array
    {
        return [
            'ReadCapacityUnits'  => 5,
            'WriteCapacityUnits' => 5,
        ];
    }

    private function cleanTableName(string $tableName): string
    {
        $key = strtolower(str_replace(['${env:', '}'], ['', ''], $tableName));

        return $this->tableNames[$key];
    }
}
