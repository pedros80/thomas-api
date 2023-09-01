<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Domain\Events;

use PHPUnit\Framework\TestCase;
use function Safe\json_encode;
use Thomas\Stations\Domain\Code;
use Thomas\Stations\Domain\Events\MessageWasAdded;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageID;
use Thomas\Stations\Domain\MessageSeverity;
use Thomas\Stations\Domain\Name;
use Thomas\Stations\Domain\Station;

final class MessageWasAddedTest extends TestCase
{
    public function testInstantiates(): void
    {
        $event = new MessageWasAdded(
            new MessageID('1234'),
            new MessageCategory(MessageCategory::MISC),
            new MessageBody('body body body'),
            new MessageSeverity(MessageSeverity::MAJOR),
            [
                new Station(new Code('DAM'), new Name('Dalmeny')),
            ]
        );

        /** @var string $json */
        $json     = json_encode($event);
        $newEvent = MessageWasAdded::deserialize($json);

        $this->assertInstanceOf(MessageWasAdded::class, $event);
        $this->assertEquals($newEvent, $event);
    }
}
