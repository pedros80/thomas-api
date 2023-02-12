<?php

namespace Tests\Unit\Thmoas\Shared\Application;

use PHPUnit\Framework\TestCase;
use Thomas\Shared\Application\DarwinCommandFactory;
use Thomas\Shared\Infrastructure\MockDarwinMessageFactory;
use Thomas\Stations\Application\Commands\RecordStationMessage;
use Thomas\Stations\Application\Commands\StationMessageToCommand;

final class DarwinCommandFactoryTest extends TestCase
{
    public function testUnknownParserReturnsNull(): void
    {
        $factory = new DarwinCommandFactory([]);
        $message = MockDarwinMessageFactory::stationMessage();
        $command = $factory->make($message);

        $this->assertNull($command);
    }

    public function testStationMessageReturnsRecordStationMessageCommand(): void
    {
        $factory = new DarwinCommandFactory([
            'OW' => new StationMessageToCommand()
        ]);
        $message = MockDarwinMessageFactory::stationMessage();
        $command = $factory->make($message);

        $this->assertInstanceOf(RecordStationMessage::class, $command);
    }
}
