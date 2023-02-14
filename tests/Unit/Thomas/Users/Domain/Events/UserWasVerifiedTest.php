<?php

namespace Tests\Unit\Thomas\Users\Domain\Events;

use PHPUnit\Framework\TestCase;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Events\UserWasVerified;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Domain\VerifyToken;

final class UserWasVerifiedTest extends TestCase
{
    public function testSerialises(): void
    {
        $userId     = UserId::generate();
        $verfyToken = VerifyToken::fromUserId($userId);

        $event = new UserWasVerified(
            new Email('peterwsomerville@gmail.com'),
            $verfyToken,
            $userId,
        );

        /** @var string $serialised */
        $serialised = json_encode($event);

        $this->assertEquals($event, UserWasVerified::deserialize($serialised));
        $this->assertEquals($userId, $event->userId());
        $this->assertEquals($verfyToken, $event->verifyToken());
        $this->assertEquals(new Email('peterwsomerville@gmail.com'), $event->email());
    }
}
