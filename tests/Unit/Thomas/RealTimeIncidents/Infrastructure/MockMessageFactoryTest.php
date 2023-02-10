<?php

namespace Tests\Unit\Thomas\RealTimeIncidents\Infrastructure;

use PHPUnit\Framework\TestCase;
use Stomp\Transport\Frame;
use Thomas\RealTimeIncidents\Infrastructure\MockMessageFactory;

final class MockMessageFactoryTest extends TestCase
{
    /**
     * @dataProvider provideMethods
     */
    public function testFactoryMethodsMakeFrames(string $method): void
    {
        $message = MockMessageFactory::$method();

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
