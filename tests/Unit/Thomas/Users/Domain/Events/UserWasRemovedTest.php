<?php

namespace Tests\Unit\Thomas\Users\Domain\Events;

use PHPUnit\Framework\TestCase;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Events\UserWasRemoved;
use Thomas\Users\Domain\UserId;

final class UserWasRemovedTest extends TestCase
{
    public function testSerialises(): void
    {
        $event = new UserWasRemoved(
            new Email('peterwsomerville@gmail.com'),
            UserId::generate(),
        );

        /** @var string $serialised */
        $serialised = json_encode($event);

        $this->assertEquals($event, UserWasRemoved::deserialize($serialised));
    }
}
