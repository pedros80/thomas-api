<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Shared\Infrastructure;

use Aws\DynamoDb\DynamoDbClient;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Thomas\Shared\Infrastructure\DynamoMigrations;

final class DynamoMigrationsTest extends TestCase
{
    use ProphecyTrait;

    private ObjectProphecy $dynamoClient;
    private DynamoMigrations $migrations;

    protected function setUp(): void
    {
        $this->dynamoClient = $this->prophesize(DynamoDbClient::class);
        $this->migrations   = new DynamoMigrations($this->dynamoClient->reveal());
    }

    public function testDropAllTablesCallsDeleteTablePerTable(): void
    {
        $names = ['table1', 'table2'];
        $this->dynamoClient->ListTables([])->willReturn(['TableNames' => $names]);
        $this->dynamoClient->deleteTable(Argument::any())->shouldBeCalledTimes(count($names));
        $this->migrations->dropAllTables();
    }

    public function testDroppingTestTablesCallsDeleteTableForEachPrefixedTable(): void
    {
        $names = ['TestTable1', 'table2'];
        $this->dynamoClient->ListTables([])->willReturn(['TableNames' => $names]);
        $this->dynamoClient->deleteTable(Argument::any())
            ->shouldBeCalledTimes(count(array_filter($names, fn (string $name) => str_starts_with($name, 'Test'))));

        $this->migrations->dropTestTables();
    }

    public function testDroppingNoTablesDoesntCallDeleteTable(): void
    {
        $this->dynamoClient->ListTables([])->willReturn(['TableNames' => []]);
        $this->dynamoClient->deleteTable(Argument::any())->shouldNotBeCalled();
        $this->migrations->dropAllTables();
    }

    public function testDroppingNoTestTablesDoesnCallDeleteTable(): void
    {
        $this->dynamoClient->ListTables([])->willReturn(['TableNames' => []]);
        $this->dynamoClient->deleteTable(Argument::any())->shouldNotBeCalled();
        $this->migrations->dropTestTables();
    }

    public function testCreateTableIfNotExistsCallsCreatedTableNoTTL(): void
    {
        $tableConfig = [
            'TableName'              => 'ATable',
            'KeySchema'              => [
                [
                    'AttributeName' => 'IntegrationId',
                    'KeyType'       => 'HASH',
                ],
            ],
            'AttributeDefinitions'   => [
                [
                    'AttributeName' => 'IntegrationId',
                    'AttributeType' => 'S',
                ],
                [
                    'AttributeName' => 'OwnerId',
                    'AttributeType' => 'S',
                ],
            ],
            'GlobalSecondaryIndexes' => [
                [
                    'IndexName'             => 'GSI-OwnerId',
                    'KeySchema'             => [
                        [
                            'AttributeName' => 'OwnerId',
                            'KeyType'       => 'HASH',
                        ],
                    ],
                    'Projection'            => [
                        'ProjectionType' => 'ALL',
                    ],
                    'ProvisionedThroughput' => [
                        'ReadCapacityUnits'  => 5,
                        'WriteCapacityUnits' => 5,
                    ],
                ],
            ],
            'ProvisionedThroughput'  => [
                'ReadCapacityUnits'  => 5,
                'WriteCapacityUnits' => 5,
            ],
        ];
        $this->dynamoClient->ListTables([])->willReturn(['TableNames' => []]);
        $this->dynamoClient->createTable(Argument::any())->shouldBeCalled();
        $this->assertEquals('Created', $this->migrations->createTableIfNotExists($tableConfig));
    }

    public function testCreateTableIfNotExistsCallsCreatedTable(): void
    {
        $tableConfig = [
            'TableName'              => 'ATable',
            'KeySchema'              => [
                [
                    'AttributeName' => 'IntegrationId',
                    'KeyType'       => 'HASH',
                ],
            ],
            'AttributeDefinitions'   => [
                [
                    'AttributeName' => 'IntegrationId',
                    'AttributeType' => 'S',
                ],
                [
                    'AttributeName' => 'OwnerId',
                    'AttributeType' => 'S',
                ],
            ],
            'TimeToLiveSpecification' => [
                'AttributeName' => 'OwnerId',
            ],
            'GlobalSecondaryIndexes' => [
                [
                    'IndexName'             => 'GSI-OwnerId',
                    'KeySchema'             => [
                        [
                            'AttributeName' => 'OwnerId',
                            'KeyType'       => 'HASH',
                        ],
                    ],
                    'Projection'            => [
                        'ProjectionType' => 'ALL',
                    ],
                    'ProvisionedThroughput' => [
                        'ReadCapacityUnits'  => 5,
                        'WriteCapacityUnits' => 5,
                    ],
                ],
            ],
            'ProvisionedThroughput'  => [
                'ReadCapacityUnits'  => 5,
                'WriteCapacityUnits' => 5,
            ],
        ];
        $this->dynamoClient->ListTables([])->willReturn(['TableNames' => []]);
        $this->dynamoClient->createTable(Argument::any())->shouldBeCalled();
        $this->dynamoClient->updateTimeToLive(
            ["TableName" => "ATable", "TimeToLiveSpecification" => ["AttributeName" => "OwnerId", "Enabled" => true]]
        )->shouldBeCalled();
        $this->assertEquals('Created', $this->migrations->createTableIfNotExists($tableConfig));
    }

    public function testCreateTableNotCalledIfTableExists(): void
    {
        $tableConfig = [
            'TableName'              => 'MyTable',
            'KeySchema'              => [
                [
                    'AttributeName' => 'IntegrationId',
                    'KeyType'       => 'HASH',
                ],
            ],
            'AttributeDefinitions'   => [
                [
                    'AttributeName' => 'IntegrationId',
                    'AttributeType' => 'S',
                ],
                [
                    'AttributeName' => 'OwnerId',
                    'AttributeType' => 'S',
                ],
            ],
            'GlobalSecondaryIndexes' => [
                [
                    'IndexName'             => 'GSI-OwnerId',
                    'KeySchema'             => [
                        [
                            'AttributeName' => 'OwnerId',
                            'KeyType'       => 'HASH',
                        ],
                    ],
                    'Projection'            => [
                        'ProjectionType' => 'ALL',
                    ],
                    'ProvisionedThroughput' => [
                        'ReadCapacityUnits'  => 5,
                        'WriteCapacityUnits' => 5,
                    ],
                ],
            ],
            'ProvisionedThroughput'  => [
                'ReadCapacityUnits'  => 5,
                'WriteCapacityUnits' => 5,
            ],
        ];

        $this->dynamoClient->ListTables([])->willReturn(['TableNames' => ['MyTable']]);
        $this->dynamoClient->createTable(Argument::any())->shouldNotBeCalled();
        $this->assertEquals('Existed', $this->migrations->createTableIfNotExists($tableConfig));
    }
}
