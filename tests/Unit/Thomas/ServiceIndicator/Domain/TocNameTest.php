<?php

namespace Tests\Unit\Thomas\ServiceIndicator\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\ServiceIndicator\Domain\TocName;

final class TocNameTest extends TestCase
{
    public function testInstantiates(): void
    {
        $tocName = new TocName('Avanti West Coast');

        $this->assertInstanceOf(TocName::class, $tocName);
        $this->assertEquals('Avanti West Coast', (string) $tocName);
    }
}
