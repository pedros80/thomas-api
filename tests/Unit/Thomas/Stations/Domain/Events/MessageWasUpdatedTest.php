<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Domain\Events;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Domain\Events\MessageWasUpdated;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageId;
use Thomas\Stations\Domain\MessageSeverity;
use Thomas\Stations\Domain\Stations;

final class MessageWasUpdatedTest extends TestCase
{
    public function testInstantiates(): void
    {
        $event = new MessageWasUpdated(
            new MessageId('12345'),
            MessageCategory::MISC,
            new MessageBody('body body body'),
            MessageSeverity::MAJOR,
            Stations::fromArray([['code' => 'DAM', 'name' => 'Dalmeny']]),
        );

        $json     = json_encode($event, JSON_THROW_ON_ERROR);
        $newEvent = MessageWasUpdated::deserialize($json);

        $this->assertEquals(new MessageId('12345'), $event->id);
        $this->assertInstanceOf(MessageWasUpdated::class, $event);
        $this->assertEquals($newEvent, $event);
    }
}
