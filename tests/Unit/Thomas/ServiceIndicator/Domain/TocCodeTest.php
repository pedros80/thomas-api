<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\ServiceIndicator\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\ServiceIndicator\Domain\TocCode;

final class TocCodeTest extends TestCase
{
    public function testInstantiates(): void
    {
        $tocCode = new TocCode('VT');

        $this->assertInstanceOf(TocCode::class, $tocCode);
        $this->assertEquals('VT', (string) $tocCode);
    }
}
