<?php

namespace Tests\Unit\Thomas\Users\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Domain\VerifyToken;

final class VerifyTokenTest extends TestCase
{
    public function testInstantiates(): void
    {
        $verifyToken = new VerifyToken('blah blah blah');

        $this->assertInstanceOf(VerifyToken::class, $verifyToken);
        $this->assertEquals('blah blah blah', (string) $verifyToken);
        $this->assertTrue($verifyToken->equals(new VerifyToken('blah blah blah')));
    }

    public function testCreateVerifyTokenFromUserId(): void
    {
        $this->assertInstanceOf(VerifyToken::class, VerifyToken::fromUserId(UserId::generate()));
    }
}
