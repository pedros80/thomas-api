<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Users\Domain\Events;

use PHPUnit\Framework\TestCase;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Events\UserWasReinstated;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\UserId;

final class UserWasReinstatedTest extends TestCase
{
    public function testSerialises(): void
    {
        $event = new UserWasReinstated(
            new Email('peterwsomerville@gmail.com'),
            UserId::generate(),
            new Name('Peter Somerville'),
            UserId::generate()
        );

        /** @var string $serialised */
        $serialised = json_encode($event);

        $this->assertEquals($event, UserWasReinstated::deserialize($serialised));
    }
}
