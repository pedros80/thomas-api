<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Domain\Events;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Domain\Code;
use Thomas\Stations\Domain\Events\MessageWasUpdated;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageID;
use Thomas\Stations\Domain\MessageSeverity;
use Thomas\Stations\Domain\Name;
use Thomas\Stations\Domain\Station;

final class MessageWasUpdatedTest extends TestCase
{
    public function testInstantiates(): void
    {
        $event = new MessageWasUpdated(
            new MessageID('12345'),
            new MessageCategory(MessageCategory::MISC),
            new MessageBody('body body body'),
            new MessageSeverity(MessageSeverity::MAJOR),
            [
                new Station(new Code('DAM'), new Name('Dalmeny')),
            ]
        );

        /** @var string $json */
        $json     = json_encode($event);
        $newEvent = MessageWasUpdated::deserialize($json);

        $this->assertEquals(new MessageID('12345'), $event->id());
        $this->assertInstanceOf(MessageWasUpdated::class, $event);
        $this->assertEquals($newEvent, $event);
    }
}
