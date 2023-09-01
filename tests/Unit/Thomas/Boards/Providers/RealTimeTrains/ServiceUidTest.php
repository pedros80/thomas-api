<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Boards\Providers\RealTimeTrains;

use PHPUnit\Framework\TestCase;
use function Safe\json_encode;
use Thomas\Boards\Providers\RealTimeTrains\Exceptions\InvalidServiceUid;
use Thomas\Boards\Providers\RealTimeTrains\ServiceUid;

final class ServiceUidTest extends TestCase
{
    public function testInstantiates(): void
    {
        $id = new ServiceUid('Y29984');

        $this->assertInstanceOf(ServiceUid::class, $id);
        $this->assertEquals('Y29984', (string) $id);
        $this->assertEquals('"Y29984"', json_encode($id));
    }

    public function testInvalidServiceUidThrowsException(): void
    {
        $this->expectException(InvalidServiceUid::class);
        $this->expectExceptionMessage("'jobby' is not a valid service id");

        new ServiceUid('jobby');
    }
}
