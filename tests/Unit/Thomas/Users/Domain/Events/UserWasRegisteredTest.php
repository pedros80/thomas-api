<?php

namespace Tests\Unit\Thomas\Users\Domain\Events;

use PHPUnit\Framework\TestCase;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Events\UserWasRegistered;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\Password;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Domain\VerifyToken;

final class UserWasRegisteredTest extends TestCase
{
    public function testSerialises(): void
    {
        $userId = UserId::generate();

        $event = new UserWasRegistered(
            new Email('peterwsomerville@gmail.com'),
            new Name('Peter Somerville'),
            Password::generate()->hash(),
            $userId,
            VerifyToken::fromUserId($userId)
        );

        /** @var string $serialised */
        $serialised = json_encode($event);

        $this->assertEquals($event, UserWasRegistered::deserialize($serialised));
    }
}
