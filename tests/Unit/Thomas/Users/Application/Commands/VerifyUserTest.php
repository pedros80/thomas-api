<?php

namespace Tests\Unit\Thomas\Users\Application\Commands;

use PHPUnit\Framework\TestCase;
use Thomas\Users\Application\Commands\VerifyUser;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Domain\VerifyToken;

final class VerifyUserTest extends TestCase
{
    public function testInstantiates(): void
    {
        $verifyToken = VerifyToken::fromUserId(UserId::generate());
        $command     = new VerifyUser(
            new Email('peterwsomerville@gmail.com'),
            $verifyToken
        );

        $this->assertEquals([
            'email'       => 'peterwsomerville@gmail.com',
            'verifyToken' => (string) $verifyToken,
        ], $command->toArray());
    }
}
