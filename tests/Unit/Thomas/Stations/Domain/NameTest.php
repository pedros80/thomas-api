<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Domain\Name;

final class NameTest extends TestCase
{
    public function testInstantiates(): void
    {
        $name = new Name('Dalmeny');

        $this->assertInstanceOf(Name::class, $name);
        $this->assertEquals('Dalmeny', (string) $name);
    }
}
