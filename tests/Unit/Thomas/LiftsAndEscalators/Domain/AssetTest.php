<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\LiftsAndEscalators\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\LiftsAndEscalators\Domain\Asset;

use function Safe\json_decode;

final class AssetTest extends TestCase
{
    public function testInstantiatesFromArray(): void
    {
        $json = '{"id":2660,"type":"Escalator","crs":"EDB","description":"E7 Waverley Steps","location":"Waverley Steps","displayName":"Escalator 7, Waverley Steps","prn":1316411,"sensorId":7514,"status":{"status":"Available","sensorId":7514,"isolated":false,"engineerOnSite":false,"independent":false}}';

        /** @var array $array */
        $array = json_decode($json, true);

        $asset = Asset::fromArray($array);

        $this->assertInstanceOf(Asset::class, $asset);
        $this->assertIsArray($asset->toArray());
        $this->assertEquals($json, json_encode($asset, JSON_THROW_ON_ERROR));
    }
}
