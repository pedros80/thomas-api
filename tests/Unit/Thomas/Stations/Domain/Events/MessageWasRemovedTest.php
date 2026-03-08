<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Domain\Events;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Domain\Events\MessageWasRemoved;
use Thomas\Stations\Domain\MessageId;

final class MessageWasRemovedTest extends TestCase
{
    public function testInstantiates(): void
    {
        $event = new MessageWasRemoved(new MessageId('12345'));

        $json     = json_encode($event, JSON_THROW_ON_ERROR);
        $newEvent = MessageWasRemoved::deserialize($json);

        $this->assertEquals(new MessageId('12345'), $event->id);
        $this->assertInstanceOf(MessageWasRemoved::class, $newEvent);
        $this->assertEquals($event, $newEvent);
    }
}
