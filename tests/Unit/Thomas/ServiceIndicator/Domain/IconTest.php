<?php

namespace Tests\Unit\Thomas\ServiceIndicator\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\ServiceIndicator\Domain\Icon;

final class IconTest extends TestCase
{
    public function testInstantiates(): void
    {
        $icon = new Icon('icon-tick2.png');

        $this->assertInstanceOf(Icon::class, $icon);
        $this->assertEquals('icon-tick2.png', (string) $icon);
    }
}
