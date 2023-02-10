<?php

namespace Tests\Unit\Thomas\Stations\Application\Commands;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Application\Commands\RecordStationMessage;
use Thomas\Stations\Application\Commands\StationMessageToCommand;
use Thomas\Stations\Infrastructure\MockMessageFactory;

final class StationMessageToCommandTest extends TestCase
{
    public function testCanConvertMessageWithNoStationsToCommand(): void
    {
        $convert = new StationMessageToCommand();
        $factory = new MockMessageFactory();
        $message = $factory->stations();
        /** @var RecordStationMessage $command */
        $command = $convert->convert($message);

        $this->assertInstanceOf(RecordStationMessage::class, $command);
        $this->assertNotEmpty($command->stations());
    }

    public function testCanConvertMessageWithStatiosToCommand(): void
    {
        $convert = new StationMessageToCommand();
        $factory = new MockMessageFactory();
        $message = $factory->noStations();
        /** @var RecordStationMessage $command */
        $command = $convert->convert($message);

        $this->assertInstanceOf(RecordStationMessage::class, $command);
        $this->assertEmpty($command->stations());
    }
}
