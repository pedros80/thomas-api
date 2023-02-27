<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Application\Commands;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Application\Commands\RemoveStationMessage;
use Thomas\Stations\Domain\MessageID;

final class RemoveStationMessageTest extends TestCase
{
    public function testInstantiates(): void
    {
        $command = new RemoveStationMessage(new MessageID('12345'));

        $this->assertInstanceOf(RemoveStationMessage::class, $command);

        $this->assertEquals(['id' => '12345'], $command->toArray());
    }
}
