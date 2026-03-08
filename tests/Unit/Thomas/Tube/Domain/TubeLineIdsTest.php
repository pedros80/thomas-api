<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Tube\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\Tube\Domain\TubeLineId;
use Thomas\Tube\Domain\TubeLineIds;

final class TubeLineIdsTest extends TestCase
{
    public function testInstantiates(): void
    {
        $ids = new TubeLineIds([TubeLineId::fromString('bakerloo')]);

        $this->assertInstanceOf(TubeLineIds::class, $ids);
    }
}
