<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Application\Commands;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Application\Commands\RecordStationMessage;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageId;
use Thomas\Stations\Domain\MessageSeverity;
use Thomas\Stations\Domain\Stations;

final class RecordStationMessageTest extends TestCase
{
    public function testInstantiates(): void
    {
        $command = new RecordStationMessage(
            new MessageId('12345'),
            MessageCategory::STATION,
            new MessageBody('body body body'),
            MessageSeverity::MAJOR,
            Stations::fromArray([['code' => 'DAM', 'name' => 'Dalmeny']]),
        );

        $this->assertInstanceOf(RecordStationMessage::class, $command);
        $this->assertEquals(
            [
                'id'       => '12345',
                'category' => MessageCategory::STATION,
                'body'     => 'body body body',
                'severity' => MessageSeverity::MAJOR,
                'stations' => Stations::fromArray([['code' => 'DAM', 'name' => 'Dalmeny']]),
            ],
            $command->toArray()
        );
    }
}
