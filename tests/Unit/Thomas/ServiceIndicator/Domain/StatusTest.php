<?php

namespace Tests\Unit\Thomas\ServiceIndicator\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\ServiceIndicator\Domain\Status;

final class StatusTest extends TestCase
{
    public function testInstantiates(): void
    {
        $status = new Status('Good service');

        $this->assertInstanceOf(Status::class, $status);
        $this->assertEquals('Good service', (string) $status);
    }
}
