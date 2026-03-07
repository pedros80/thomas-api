<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Tube\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\Tube\Domain\Exceptions\InvalidTubeLineId;
use Thomas\Tube\Domain\TubeLineId;
use Thomas\Tube\Domain\TubeLineIds;

final class TubeLineIdTest extends TestCase
{
    public function testInstantiates(): void
    {
        $id = TubeLineId::fromString('bakerloo');

        $this->assertInstanceOf(TubeLineId::class, $id);
        $this->assertEquals('bakerloo', (string) $id);
        $this->assertEquals('tube', $id->mode());
        $this->assertEquals('Bakerloo', $id->name());
        $this->assertEquals('"bakerloo"', json_encode($id, JSON_THROW_ON_ERROR));
    }

    public function testAllReturnsCollection(): void
    {
        $all = TubeLineId::all();

        $this->assertInstanceOf(TubeLineIds::class, $all);
    }

    public function testInvalidIdThrowsException(): void
    {
        $this->expectException(InvalidTubeLineId::class);
        $this->expectExceptionMessage("'jobby' is not a valid Tube Line ID. Please try again.");

        TubeLineId::fromString('jobby');
    }
}
