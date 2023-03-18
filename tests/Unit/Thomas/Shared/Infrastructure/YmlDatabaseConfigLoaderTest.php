<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Shared\Infrastructure;

use PHPUnit\Framework\TestCase;
use Thomas\Shared\Infrastructure\YmlDatabaseConfigLoader;

class YmlDatabaseConfigLoaderTest extends TestCase
{
    private YmlDatabaseConfigLoader $configLoader;

    protected function setUp(): void
    {
        $definitions = [
            'Resources' => [
                'FirstTable' => [
                    'Type'           => 'AWS::DynamoDB::Table',
                    'DeletionPolicy' => 'Retain',
                    'Properties'     => [
                        'Replicas'             => '${self:custom.replicas.${self:provider.stage}}',
                        'AttributeDefinitions' => [
                            [
                                'AttributeName' => 'FirstTableId',
                                'AttributeType' => 'S',
                            ],
                            [
                                'AttributeName' => 'SecondId',
                                'AttributeType' => 'S',
                            ],
                        ],
                        'KeySchema' => [
                            [
                                'AttributeName' => 'FirstTableId',
                                'KeyType'       => 'HASH',
                            ],
                        ],
                        'GlobalSecondaryIndexes' => [
                            [
                                'IndexName' => 'Second-index',
                                'KeySchema' => [
                                    0 => [
                                        'AttributeName' => 'SecondId',
                                        'KeyType'       => 'HASH',
                                    ],
                                ],
                                'Projection' => [
                                    'ProjectionType' => 'ALL',
                                ],
                                'ProvisionedThroughput' => [
                                    'ReadCapacityUnits'  => 5,
                                    'WriteCapacityUnits' => 5,
                                ],
                            ],
                        ],
                        'ProvisionedThroughput' => [
                            'ReadCapacityUnits'  => 5,
                            'WriteCapacityUnits' => 5,
                        ],
                        'BillingMode'         => 'PAY_PER_REQUEST',
                        'TableName'           => '${env:FIRST_TABLE_NAME}',
                        'StreamSpecification' => [
                            'StreamViewType' => 'NEW_AND_OLD_IMAGES',
                        ],
                    ],
                ],
                'SecondTable' => [
                    'Type'           => 'AWS::DynamoDB::Table',
                    'DeletionPolicy' => 'Retain',
                    'Properties'     => [
                        'Replicas'             => '${self:custom.replicas.${self:provider.stage}}',
                        'AttributeDefinitions' => [
                            [
                                'AttributeName' => 'SecondTableId',
                                'AttributeType' => 'S',
                            ],
                            [
                                'AttributeName' => 'FirstTableId',
                                'AttributeType' => 'S',
                            ],
                            [
                                'AttributeName' => 'SecondId',
                                'AttributeType' => 'N',
                            ],
                        ],
                        'KeySchema' => [
                            [
                                'AttributeName' => 'SecondTableId',
                                'KeyType'       => 'HASH',
                            ],
                        ],
                        'GlobalSecondaryIndexes' => [
                            [
                                'IndexName' => 'FirstTable-index',
                                'KeySchema' => [
                                    [
                                        'AttributeName' => 'FirstTableId',
                                        'KeyType'       => 'HASH',
                                    ],
                                    [
                                        'AttributeName' => 'SecondId',
                                        'KeyType'       => 'RANGE',
                                    ],
                                ],
                                'Projection' => [
                                    'ProjectionType' => 'ALL',
                                ],
                                'ProvisionedThroughput' => [
                                    'ReadCapacityUnits'  => 5,
                                    'WriteCapacityUnits' => 5,
                                ],
                            ],
                        ],
                        'ProvisionedThroughput' => [
                            'ReadCapacityUnits'  => 5,
                            'WriteCapacityUnits' => 5,
                        ],
                        'BillingMode'         => 'PAY_PER_REQUEST',
                        'TableName'           => '${env:SECOND_TABLE_NAME}',
                        'StreamSpecification' => [
                            'StreamViewType' => 'NEW_AND_OLD_IMAGES',
                        ],
                    ],
                ],
                'ThirdTable' => [
                    'Type'           => 'AWS::DynamoDB::Table',
                    'DeletionPolicy' => 'Retain',
                    'Properties'     => [
                        'Replicas'             => '${self:custom.replicas.${self:provider.stage}}',
                        'AttributeDefinitions' => [
                            [
                                'AttributeName' => 'ThirdTableId',
                                'AttributeType' => 'S',
                            ],
                        ],
                        'TimeToLiveSpecification' => [
                            'Attributes' => [
                                'Hello' => 'Dummy until real attributes are gotten...',
                            ],
                        ],
                        'KeySchema' => [
                            [
                                'AttributeName' => 'ThirdTableId',
                                'KeyType'       => 'HASH',
                            ],
                        ],
                        'ProvisionedThroughput' => [
                            'ReadCapacityUnits'  => 5,
                            'WriteCapacityUnits' => 5,
                        ],
                        'BillingMode'         => 'PAY_PER_REQUEST',
                        'TableName'           => '${env:THIRD_TABLE_NAME}',
                        'StreamSpecification' => [
                            'StreamViewType' => 'NEW_AND_OLD_IMAGES',
                        ],
                    ],
                ],
            ],
        ];

        $tableNames = [
            'first_table_name'  => 'FirstTable',
            'second_table_name' => 'SecondTable',
            'third_table_name'  => 'ThirdTable',
        ];

        $this->configLoader = new YmlDatabaseConfigLoader($definitions, $tableNames);
    }

    public function testWhenReturnsCorrectTableAndTestDefinitions(): void
    {
        $response = $this->configLoader->getTableDefinitions();

        $this->assertEquals(6, count($response)); // 3 tables and 3 test tables...
        $this->assertEquals('FirstTable', $response[0]['TableName']);
        $this->assertEquals('TestFirstTable', $response[1]['TableName']);
        $this->assertEquals('SecondTable', $response[2]['TableName']);
        $this->assertArrayHasKey('KeySchema', $response[0]);
        $this->assertCount(2, $response[0]['AttributeDefinitions']);
        $this->assertCount(3, $response[2]['AttributeDefinitions']);
    }

    public function testNotHavingGlobalSecondaryIndexes(): void
    {
        $response = $this->configLoader->getTableDefinitions();

        $this->assertArrayHasKey('GlobalSecondaryIndexes', $response[0]);
        $this->assertArrayHasKey('GlobalSecondaryIndexes', $response[1]);
        $this->assertArrayHasKey('GlobalSecondaryIndexes', $response[2]);
        $this->assertArrayHasKey('GlobalSecondaryIndexes', $response[3]);
        $this->assertArrayNotHasKey('GlobalSecondaryIndexes', $response[4]);
        $this->assertArrayNotHasKey('GlobalSecondaryIndexes', $response[5]);
    }
}
