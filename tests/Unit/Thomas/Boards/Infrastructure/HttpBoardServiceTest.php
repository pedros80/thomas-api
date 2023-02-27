<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Boards\Infrastructure;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Thomas\Boards\Domain\BoardClient;
use Thomas\Boards\Infrastructure\HttpBoardService;

final class HttpBoardServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testBusServicesAreRemovedFromData(): void
    {
        /** @var string $data */
        $data = json_encode([
            'GetStationBoardResult' => [
                'generatedAt'       => '2023-02-02T23:54:00.0627469+00:00',
                'locationName'      => 'Dalmeny',
                'crs'               => 'DAM',
                'platformAvailable' => true,
                'busServices'       => [
                    'this will be removed',
                ],
            ],
        ]);

        $client = $this->prophesize(BoardClient::class);
        $client->getDepBoardWithDetails(10, 'DAM')->willReturn(json_decode($data));
        $service = new HttpBoardService(
            $client->reveal(),
            10
        );

        $result = $service->departuresPlatform('dam', '1');

        $this->assertTrue($result->GetStationBoardResult->platformAvailable);
        $this->assertFalse(isset($result->GetStationBoardResult->busServices));
    }

    public function testPlatformWithNoTrainServicesAndNoNRCCMessagesReturns(): void
    {
        /** @var string $data */
        $data = json_encode([
            'GetStationBoardResult' => [
                'generatedAt'       => '2023-02-02T23:54:00.0627469+00:00',
                'locationName'      => 'Dalmeny',
                'crs'               => 'DAM',
                'platformAvailable' => true,
            ],
        ]);

        $client = $this->prophesize(BoardClient::class);
        $client->getDepBoardWithDetails(10, 'DAM')->willReturn(json_decode($data));
        $service = new HttpBoardService(
            $client->reveal(),
            10
        );

        $result = $service->departuresPlatform('dam', '1');

        $this->assertTrue($result->GetStationBoardResult->platformAvailable);
    }

    public function testPlatformWithNoTrainServicesReturns(): void
    {
        /** @var string $data */
        $data = json_encode([
            'GetStationBoardResult' => [
                'generatedAt'  => '2023-02-02T23:54:00.0627469+00:00',
                'locationName' => 'Dalmeny',
                'crs'          => 'DAM',
                'nrccMessages' => [
                    'message' => [
                        [
                            '_' => '<p> A gas leak near the railway at Carnoustie means all lines are closed. Trains running through the station may be cancelled or revised. More details can be found in <a href="http://nationalrail.co.uk/service_disruptions/316990.aspx">Latest Travel News</a>.</p>',
                        ],
                        [
                            '_' => 'Severe weather is affecting various routes across the ScotRail network. More details can be found in<a href="http://nationalrail.co.uk/service_disruptions/317000.aspx"> Latest Travel News</a>.',
                        ],
                    ],
                ],
                'platformAvailable' => true,
            ],
        ]);

        $client = $this->prophesize(BoardClient::class);
        $client->getDepBoardWithDetails(10, 'DAM')->willReturn(json_decode($data));
        $service = new HttpBoardService(
            $client->reveal(),
            10
        );

        $result = $service->departuresPlatform('dam', '1');

        $this->assertTrue($result->GetStationBoardResult->platformAvailable);
    }

    public function testPlatformWithTrainServicesFiltersByPlatform(): void
    {
        /** @var string $data */
        $data = json_encode([
            'GetStationBoardResult' => [
                'generatedAt'       => '2023-02-02T23:54:00.0627469+00:00',
                'locationName'      => 'Dalmeny',
                'crs'               => 'DAM',
                'platformAvailable' => true,
                'trainServices'     => [
                    'service' => [
                        [
                            'std'      => '00:22',
                            'etd'      => 'On time',
                            'platform' => '1',
                        ],
                        [
                            'std'      => '00:22',
                            'etd'      => 'On time',
                            'platform' => '2',
                        ],
                    ],
                ],
            ],
        ]);

        $client = $this->prophesize(BoardClient::class);
        $client->getDepBoardWithDetails(10, 'DAM')->willReturn(json_decode($data));
        $service = new HttpBoardService(
            $client->reveal(),
            10
        );

        $result = $service->departuresPlatform('dam', '1');

        $this->assertTrue($result->GetStationBoardResult->platformAvailable);
        $this->assertCount(1, $result->GetStationBoardResult->trainServices->service);
    }

    public function testDeparturesBoard(): void
    {
        /** @var string $data */
        $data = json_encode([
            'GetStationBoardResult' => [
                'generatedAt'       => '2023-02-02T23:54:00.0627469+00:00',
                'locationName'      => 'Dalmeny',
                'crs'               => 'DAM',
                'platformAvailable' => true,
                'trainServices'     => [
                    'service' => [
                        [
                            'std'      => '00:22',
                            'etd'      => 'On time',
                            'platform' => '1',
                        ],
                        [
                            'std'      => '00:22',
                            'etd'      => 'On time',
                            'platform' => '2',
                        ],
                    ],
                ],
            ],
        ]);

        $client = $this->prophesize(BoardClient::class);
        $client->getDepBoardWithDetails(10, 'DAM')->willReturn(json_decode($data));
        $service = new HttpBoardService(
            $client->reveal(),
            10
        );

        $result = $service->departures('dam');

        $this->assertTrue($result->GetStationBoardResult->platformAvailable);
        $this->assertCount(2, $result->GetStationBoardResult->trainServices->service);
    }

    public function testArrivalsBoard(): void
    {
        /** @var string $data */
        $data = json_encode([
            'GetStationBoardResult' => [
                'generatedAt'       => '2023-02-02T23:54:00.0627469+00:00',
                'locationName'      => 'Dalmeny',
                'crs'               => 'DAM',
                'platformAvailable' => true,
                'trainServices'     => [
                    'service' => [
                        [
                            'sta'      => '00:22',
                            'eta'      => 'On time',
                            'platform' => '1',
                        ],
                        [
                            'sta'      => '00:22',
                            'eta'      => 'On time',
                            'platform' => '2',
                        ],
                    ],
                ],
            ],
        ]);

        $client = $this->prophesize(BoardClient::class);
        $client->getArrBoardWithDetails(10, 'DAM')->willReturn(json_decode($data));
        $service = new HttpBoardService(
            $client->reveal(),
            10
        );

        $result = $service->arrivals('dam');

        $this->assertTrue($result->GetStationBoardResult->platformAvailable);
        $this->assertCount(2, $result->GetStationBoardResult->trainServices->service);
    }
}
