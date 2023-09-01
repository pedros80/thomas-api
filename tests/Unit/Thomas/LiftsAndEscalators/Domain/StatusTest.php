<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\LiftsAndEscalators\Domain;

use function Safe\json_encode;
use PHPUnit\Framework\TestCase;
use Thomas\LiftsAndEscalators\Domain\Exceptions\InvalidStatus;
use Thomas\LiftsAndEscalators\Domain\Status;

final class StatusTest extends TestCase
{
    public function testInstantiates(): void
    {
        $available = new Status(Status::AVAILABLE);

        $this->assertInstanceOf(Status::class, $available);
        $this->assertEquals(Status::AVAILABLE, (string) $available);
        $this->assertEquals('"Available"', json_encode($available));
    }

    public function testInvalidStatusThrowsException(): void
    {
        $this->expectException(InvalidStatus::class);
        $this->expectExceptionMessage("'jobby' is not a valid Status");

        new Status('jobby');
    }
}
