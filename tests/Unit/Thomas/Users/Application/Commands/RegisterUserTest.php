<?php

namespace Tests\Unit\Thomas\Users\Application\Commands;

use PHPUnit\Framework\TestCase;
use Thomas\Users\Application\Commands\RegisterUser;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\Password;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Domain\VerifyToken;

final class RegisterUserTest extends TestCase
{
    public function testInstantiates(): void
    {
        $password    = Password::generate();
        $userId      = UserId::generate();
        $verifyToken = VerifyToken::fromUserId($userId);

        $command = new RegisterUser(
            new Email('peterwsomerville@gmail.com'),
            new Name('Peter Somerville'),
            $password,
            $userId,
            $verifyToken
        );

        $this->assertEquals([
            'email' => 'peterwsomerville@gmail.com',
            'name'  => 'Peter Somerville',
        ], $command->toArray());
    }
}
