<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Domain\Exceptions\InvalidSeverity;
use Thomas\Stations\Domain\MessageSeverity;

final class MessageSeverityTest extends TestCase
{
    public function testInstantiates(): void
    {
        $severity = new MessageSeverity(MessageSeverity::MAJOR);

        $this->assertInstanceOf(MessageSeverity::class, $severity);
        $this->assertEquals(MessageSeverity::MAJOR, $severity->toInt());
        $this->assertEquals('major', (string) $severity);
    }

    public function testNegativeSeverityThrowsException(): void
    {
        $this->expectException(InvalidSeverity::class);
        $this->expectExceptionMessage("'-1' is not a valid message severity.");

        new MessageSeverity(-1);
    }

    public function testInvalidSeverityThrowsException(): void
    {
        $this->expectException(InvalidSeverity::class);
        $this->expectExceptionMessage("'6' is not a valid message severity.");

        new MessageSeverity(6);
    }
}
