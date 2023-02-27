<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Application\Commands;

use PHPUnit\Framework\TestCase;
use Thomas\Shared\Infrastructure\MockDarwinMessageFactory;
use Thomas\Stations\Application\Commands\RecordStationMessage;
use Thomas\Stations\Application\Commands\StationMessageToCommand;

final class StationMessageToCommandTest extends TestCase
{
    public function testCanConvertMessageWithStationsToCommand(): void
    {
        $converter = new StationMessageToCommand();
        /** @var RecordStationMessage $command */
        $command = $converter->convert(MockDarwinMessageFactory::stationMessage(1));

        $this->assertInstanceOf(RecordStationMessage::class, $command);
        $this->assertNotEmpty($command->stations());
    }

    public function testCanConvertMessageWithoutStationsToCommand(): void
    {
        $converter = new StationMessageToCommand();
        /** @var RecordStationMessage $command */
        $command = $converter->convert(MockDarwinMessageFactory::stationMessage());

        $this->assertInstanceOf(RecordStationMessage::class, $command);
        $this->assertEmpty($command->stations());
    }
}
