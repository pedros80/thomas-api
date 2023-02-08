<?php

namespace Tests\Unit\Thomas\RealTimeIncidents\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\RealTimeIncidents\Domain\Exceptions\InvalidIncidentMessageStatus;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;

final class IncidentMessageStatusTest extends TestCase
{
    public function testInstantiates(): void
    {
        $status = IncidentMessageStatus::new();

        $this->assertInstanceOf(IncidentMessageStatus::class, $status);
        $this->assertEquals('NEW', (string) $status);

        $status = IncidentMessageStatus::modified();

        $this->assertInstanceOf(IncidentMessageStatus::class, $status);
        $this->assertEquals('MODIFIED', (string) $status);

        $status = IncidentMessageStatus::removed();

        $this->assertInstanceOf(IncidentMessageStatus::class, $status);
        $this->assertEquals('REMOVED', (string) $status);
    }

    public function testInvalidStatusThrowsException(): void
    {
        $this->expectException(InvalidIncidentMessageStatus::class);
        $this->expectExceptionMessage("'JOBBY' is not a valid Incident Message Status");

        new IncidentMessageStatus('JOBBY');
    }
}
