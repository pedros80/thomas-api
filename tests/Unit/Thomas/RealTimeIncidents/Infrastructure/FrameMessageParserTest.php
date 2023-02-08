<?php

namespace Tests\Unit\Thomas\RealTimeIncidents\Infrastructure;

use PHPUnit\Framework\TestCase;
use Stomp\Transport\Frame;
use Thomas\RealTimeIncidents\Domain\Incident;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;
use Thomas\RealTimeIncidents\Infrastructure\FrameMessageParser;
use Thomas\RealTimeIncidents\Infrastructure\MessageFactory;

final class FrameMessageParserTest extends TestCase
{
    /**
     * @dataProvider provideMessages
     */
    public function testFrameMessageParsedToCorrectIncidentType(string $method, Frame $message): void
    {
        $parser = new FrameMessageParser();
        $incident = $parser->parse($message);

        $this->assertInstanceOf(Incident::class, $incident);
        $this->assertEquals(IncidentMessageStatus::$method(), $incident->status());
    }

    public function provideMessages(): array
    {
        return [
            ['method' => 'new', 'message' => MessageFactory::new()],
            ['method' => 'modified', 'message' => MessageFactory::modified()],
            ['method' => 'removed', 'message' => MessageFactory::removed()],
        ];
    }
}
