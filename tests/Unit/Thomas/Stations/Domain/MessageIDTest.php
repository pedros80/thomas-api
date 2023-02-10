<?php

namespace Tests\Unit\Thomas\Stations\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Domain\MessageID;

final class MessageIDTest extends TestCase
{
    public function testInstantiates(): void
    {
        $id = new MessageID('12345');

        $this->assertInstanceOf(MessageID::class, $id);
        $this->assertEquals('12345', (string) $id);
    }
}
