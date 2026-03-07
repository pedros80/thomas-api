<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Application\Commands;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Application\Commands\RecordStationMessage;
use Thomas\Stations\Domain\Code;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageID;
use Thomas\Stations\Domain\MessageSeverity;
use Thomas\Stations\Domain\Name;
use Thomas\Stations\Domain\Station;
use Thomas\Stations\Domain\Stations;

final class RecordStationMessageTest extends TestCase
{
    public function testInstantiates(): void
    {
        $command = new RecordStationMessage(
            new MessageID('12345'),
            MessageCategory::STATION,
            new MessageBody('body body body'),
            MessageSeverity::MAJOR,
            new Stations([
                new Station(new Code('DAM'), new Name('Dalmeny')),
            ])
        );

        $this->assertInstanceOf(RecordStationMessage::class, $command);
        $this->assertEquals(
            [
                'id'       => '12345',
                'category' => MessageCategory::STATION,
                'body'     => 'body body body',
                'severity' => MessageSeverity::MAJOR,
                'stations' => new Stations([
                    new Station(new Code('DAM'), new Name('Dalmeny')),
                ]),
            ],
            $command->toArray()
        );
    }
}
