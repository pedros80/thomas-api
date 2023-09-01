<?php

declare(strict_types=1);

namespace Tests\Feature\Thomas\LiftsAndEscalators\Infrastructure;

use Tests\TestCase;
use Thomas\LiftsAndEscalators\Domain\Asset;
use Thomas\LiftsAndEscalators\Domain\AssetId;
use Thomas\LiftsAndEscalators\Domain\Assets;
use Thomas\LiftsAndEscalators\Domain\AssetStatus;
use Thomas\LiftsAndEscalators\Domain\AssetStatuses;
use Thomas\LiftsAndEscalators\Domain\Exceptions\AssetNotFound;
use Thomas\LiftsAndEscalators\Domain\Exceptions\NoSensorsFound;
use Thomas\LiftsAndEscalators\Domain\Exceptions\SensorNotFound;
use Thomas\LiftsAndEscalators\Domain\SensorId;
use Thomas\LiftsAndEscalators\Infrastructure\HttpLiftAndEscalatorClient;
use Thomas\Shared\Domain\CRS;
use Thomas\Shared\Domain\Exceptions\ExternalDataConnectionFailure;

final class HttpLiftAndEscalatorClientTest extends TestCase
{
    private HttpLiftAndEscalatorClient $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = app(HttpLiftAndEscalatorClient::class);
    }

    public function testGetAssetsByStationCodeWithAssetsReturnsAssets(): void
    {
        $assets = $this->client->getAssetsByStationCode(CRS::fromString('EDB'));

        $this->assertInstanceOf(Assets::class, $assets);
        $this->assertCount(23, $assets);
    }

    public function testGetAssetsByStationCodeWithNoAssetsReturnsEmptyAssets(): void
    {
        $assets = $this->client->getAssetsByStationCode(CRS::fromString('DAM'));

        $this->assertInstanceOf(Assets::class, $assets);
        $this->assertCount(0, $assets);
    }

    public function testGetAssetsByStationCodeThrowsExceptionOnErrors(): void
    {
        $this->expectException(ExternalDataConnectionFailure::class);
        $this->expectExceptionMessage('Error getting data from Lifts And Escalators: rate limit of 15 exceeded');

        $this->client->getAssetsByStationCode(CRS::fromString('KGX'));
    }

    public function testGetAssetByIdReturnsAsset(): void
    {
        $asset = $this->client->getAssetById(new AssetId(1160));

        $this->assertInstanceOf(Asset::class, $asset);
    }

    public function testGetUnknownAssetThrowsException(): void
    {
        $this->expectException(AssetNotFound::class);
        $this->expectExceptionMessage("Asset '9999' not found.");

        $this->client->getAssetById(new AssetId(9999));
    }

    public function testGetAssetByIdThrowsExceptionOnError(): void
    {
        $this->expectException(ExternalDataConnectionFailure::class);
        $this->expectExceptionMessage('Error getting data from Lifts And Escalators: rate limit of 15 exceeded');

        $this->client->getAssetById(new AssetId(10000));
    }

    public function testGetKnownSensorByIdReturnsAssetStatus(): void
    {
        $sensor = $this->client->getSensorById(new SensorId(2005));

        $this->assertInstanceOf(AssetStatus::class, $sensor);
    }

    public function testGetUnknownSensorByIdThrowsException(): void
    {
        $this->expectException(SensorNotFound::class);
        $this->expectExceptionMessage("Sensor '9999' not found.");

        $this->client->getSensorById(new SensorId(9999));
    }

    public function testGetSensorByIdThrowsExceptionOnError(): void
    {
        $this->expectException(ExternalDataConnectionFailure::class);
        $this->expectExceptionMessage('Error getting data from Lifts And Escalators: rate limit of 15 exceeded');

        $this->client->getSensorById(new SensorId(10000));
    }

    public function testGetSensorByIdClientExceptionThrowsException(): void
    {
        $this->expectException(ExternalDataConnectionFailure::class);
        $this->expectExceptionMessage('Error getting data from Lifts And Escalators: Access denied due to invalid subscription key');

        $this->client->getSensorById(new SensorId(10001));
    }

    public function testGetSensorsReturnsAssetStatuses(): void
    {
        $sensors = $this->client->getSensors(1, 1);

        $this->assertInstanceOf(AssetStatuses::class, $sensors);
    }

    public function testEmptyGetSensorsThrowsException(): void
    {
        $this->expectException(NoSensorsFound::class);
        $this->expectExceptionMessage('No Sensors found for offset 0');

        $this->client->getSensors(9999);
    }

    public function testGetSensorsThrowsExceptionOnError(): void
    {
        $this->expectException(ExternalDataConnectionFailure::class);
        $this->expectExceptionMessage('Error getting data from Lifts And Escalators: rate limit of 15 exceeded');

        $this->client->getSensors(10000);
    }

    public function testGetSensorsClientExceptionThrowsException(): void
    {
        $this->expectException(ExternalDataConnectionFailure::class);
        $this->expectExceptionMessage('Error getting data from Lifts And Escalators: Access denied due to invalid subscription key');

        $this->client->getSensors(10001);
    }
}
