<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Users\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\Users\Domain\Exceptions\InvalidUserId;
use Thomas\Users\Domain\UserId;

final class UserIdTest extends TestCase
{
    public function testInstantiates(): void
    {
        $userId = new UserId('01GS6MBYP8QGBMM26J56Q43FM0');

        $this->assertInstanceOf(UserId::class, $userId);
        $this->assertEquals('01GS6MBYP8QGBMM26J56Q43FM0', (string) $userId);
    }

    public function testGenerateReturnsValidId(): void
    {
        $userId = UserId::generate();

        $this->assertInstanceOf(UserId::class, $userId);
    }

    public function testInvalidUserIdThrowsException(): void
    {
        $this->expectException(InvalidUserId::class);
        $this->expectExceptionMessage("'jobby' is not a valid user id.");

        new UserId('jobby');
    }
}
