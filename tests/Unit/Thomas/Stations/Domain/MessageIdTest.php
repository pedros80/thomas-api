<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Domain\MessageId;

final class MessageIdTest extends TestCase
{
    public function testInstantiates(): void
    {
        $id = new MessageId('12345');

        $this->assertInstanceOf(MessageId::class, $id);
        $this->assertEquals('12345', (string) $id);
    }
}
