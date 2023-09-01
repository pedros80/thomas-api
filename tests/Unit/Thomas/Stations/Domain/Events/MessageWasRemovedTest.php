<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Domain\Events;

use function Safe\json_encode;
use PHPUnit\Framework\TestCase;
use Thomas\Stations\Domain\Events\MessageWasRemoved;
use Thomas\Stations\Domain\MessageID;

final class MessageWasRemovedTest extends TestCase
{
    public function testInstantiates(): void
    {
        $event = new MessageWasRemoved(new MessageID('12345'));

        /** @var string $json */
        $json     = json_encode($event);
        $newEvent = MessageWasRemoved::deserialize($json);

        $this->assertEquals(new MessageID('12345'), $event->id());
        $this->assertInstanceOf(MessageWasRemoved::class, $newEvent);
        $this->assertEquals($event, $newEvent);
    }
}
