<?php

namespace Tests\Unit\Thomas\Stations\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Domain\Code;

final class CodeTest extends TestCase
{
    public function testInstantiates(): void
    {
        $code = new Code('DAM');

        $this->assertInstanceOf(Code::class, $code);
        $this->assertEquals('DAM', (string) $code);
    }
}
