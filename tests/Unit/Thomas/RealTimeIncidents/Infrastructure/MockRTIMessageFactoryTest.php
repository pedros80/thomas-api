<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\RealTimeIncidents\Infrastructure;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Stomp\Transport\Frame;
use Thomas\RealTimeIncidents\Infrastructure\MockRTIMessageFactory;

final class MockRTIMessageFactoryTest extends TestCase
{
    #[DataProvider('provideMethods')]
    public function testFactoryMethodsMakeFrames(string $method): void
    {
        $message = MockRTIMessageFactory::$method();

        $this->assertInstanceOf(Frame::class, $message);
        $this->assertEquals(strtoupper($method), $message->getHeaders()['INCIDENT_MESSAGE_STATUS']);
    }

    public static function provideMethods(): array
    {
        return [
            ['method' => 'new'],
            ['method' => 'modified'],
            ['method' => 'removed'],
        ];
    }
}
