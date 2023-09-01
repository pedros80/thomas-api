<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\LiftsAndEscalators\Domain;

use PHPUnit\Framework\TestCase;
use function Safe\json_encode;
use Thomas\LiftsAndEscalators\Domain\AssetType;
use Thomas\LiftsAndEscalators\Domain\Exceptions\InvalidAssetType;

final class AssetTypeTest extends TestCase
{
    public function testInstantiates(): void
    {
        $escalator = new AssetType(AssetType::ESCALATOR);

        $this->assertInstanceOf(AssetType::class, $escalator);
        $this->assertEquals(AssetType::ESCALATOR, (string) $escalator);
        $this->assertEquals('"Escalator"', json_encode($escalator));
    }

    public function testInvalidTypeThrowsException(): void
    {
        $this->expectException(InvalidAssetType::class);
        $this->expectExceptionMessage("'jobby' is not a valid Asset Type");

        new AssetType('jobby');
    }
}
