<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Domain\Events;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Domain\Code;
use Thomas\Stations\Domain\Events\MessageWasAdded;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageID;
use Thomas\Stations\Domain\MessageSeverity;
use Thomas\Stations\Domain\Name;
use Thomas\Stations\Domain\Station;
use Thomas\Stations\Domain\Stations;

final class MessageWasAddedTest extends TestCase
{
    public function testInstantiates(): void
    {
        $event = new MessageWasAdded(
            new MessageID('1234'),
            MessageCategory::MISC,
            new MessageBody('body body body'),
            MessageSeverity::MAJOR,
            new Stations([
                new Station(new Code('DAM'), new Name('Dalmeny')),
            ])
        );

        /** @var string $json */
        $json     = json_encode($event, JSON_THROW_ON_ERROR);
        $newEvent = MessageWasAdded::deserialize($json);

        $this->assertInstanceOf(MessageWasAdded::class, $event);
        $this->assertEquals($newEvent, $event);
    }
}
