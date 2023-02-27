<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\RealTimeIncidents\Infrastructure;

use PHPUnit\Framework\TestCase;
use Stomp\Transport\Frame;
use Thomas\RealTimeIncidents\Infrastructure\MockRTIMessageFactory;

final class MockRTIMessageFactoryTest extends TestCase
{
    /**
     * @dataProvider provideMethods
     */
    public function testFactoryMethodsMakeFrames(string $method): void
    {
        $message = MockRTIMessageFactory::$method();

        $this->assertInstanceOf(Frame::class, $message);
        $this->assertEquals(strtoupper($method), $message->getHeaders()['INCIDENT_MESSAGE_STATUS']);
    }

    public function provideMethods(): array
    {
        return [
            ['method' => 'new'],
            ['method' => 'modified'],
            ['method' => 'removed'],
        ];
    }
}
