<?php

namespace Tests\Unit\Thomas\Users\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\Users\Domain\Name;

final class NameTest extends TestCase
{
    public function testInstantiates(): void
    {
        $name = new Name('Peter Somerville');

        $this->assertInstanceOf(Name::class, $name);
        $this->assertEquals('Peter Somerville', (string) $name);
    }
}
