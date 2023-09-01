<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\LiftsAndEscalators\Domain;

use function Safe\json_decode;
use function Safe\json_encode;
use PHPUnit\Framework\TestCase;
use Thomas\LiftsAndEscalators\Domain\Asset;

final class AssetTest extends TestCase
{
    public function testInstantiatesFromArray(): void
    {
        $json = '{"id":"2660","type":"Escalator","crs":"EDB","description":"E7 Waverley Steps","location":"Waverley Steps","displayName":"Escalator 7, Waverley Steps","prn":"1316411","sensorId":"7514","status":{"status":"Available","sensorId":"7514","isolated":false,"engineerOnSite":false,"independent":false}}';

        $asset = Asset::fromArray(json_decode($json, true));

        $this->assertInstanceOf(Asset::class, $asset);
        $this->assertIsArray($asset->toArray());
        $this->assertEquals($json, json_encode($asset));
    }
}
