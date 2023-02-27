<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\RealTimeIncidents\Application\Commands;

use PHPUnit\Framework\TestCase;
use Thomas\RealTimeIncidents\Application\Commands\RTICommandFactory;
use Thomas\RealTimeIncidents\Infrastructure\MockRTIMessageFactory;

final class RTICommandFactoryTest extends TestCase
{
    public function testUnknownMesageTypeReturnsNull(): void
    {
        $factory = new RTICommandFactory([]);

        $this->assertNull($factory->make(MockRTIMessageFactory::new()));
    }
}
