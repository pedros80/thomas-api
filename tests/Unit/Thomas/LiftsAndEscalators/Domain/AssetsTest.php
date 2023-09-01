<?php

namespace Tests\Unit\Thomas\LiftsAndEscalators\Domain;

use PHPUnit\Framework\TestCase;
use Tests\Mocks\Pedros80\LANDEphp\Services\MockLiftAndEscalatorService;
use Tests\Mocks\Pedros80\LANDEphp\Services\MockTokenGenerator;
use Thomas\LiftsAndEscalators\Domain\Asset;
use Thomas\LiftsAndEscalators\Domain\Assets;
use Thomas\LiftsAndEscalators\Infrastructure\HttpLiftAndEscalatorClient;
use Thomas\LiftsAndEscalators\Infrastructure\HttpTokenService;
use Thomas\Shared\Domain\CRS;
use Thomas\Shared\Domain\Exceptions\InvalidTypeForCollection;

final class AssetsTest extends TestCase
{
    public function testInstantiates(): void
    {
        $service = new HttpLiftAndEscalatorClient(
            new MockLiftAndEscalatorService(),
            new HttpTokenService(new MockTokenGenerator())
        );

        $assets = $service->getAssetsByStationCode(CRS::fromString('edb'));

        $this->assertInstanceOf(Assets::class, $assets);
        $this->assertCount(23, $assets);

        foreach ($assets as $asset) {
            $this->assertInstanceOf(Asset::class, $asset);
        }

        $ids = $assets->map(fn (Asset $asset) => $asset->toArray()['id']);
        $this->assertCount(23, $ids);

        $array = $assets->toArray();
        $this->assertIsArray($array);
    }

    public function testNonAssetThrowsException(): void
    {
        $this->expectException(InvalidTypeForCollection::class);
        $this->expectExceptionMessage('Object should be Thomas\LiftsAndEscalators\Domain\Asset.');

        new Assets([1, 2, 3]);
    }
}
