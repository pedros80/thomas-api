<?php

namespace Tests\Unit\Thomas\Stations\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Domain\MessageBody;

final class MessageBodyTest extends TestCase
{
    public function testInstantiates(): void
    {
        $body = new MessageBody('Here is some spiel');

        $this->assertInstanceOf(MessageBody::class, $body);
        $this->assertEquals('Here is some spiel', (string) $body);
    }
}
