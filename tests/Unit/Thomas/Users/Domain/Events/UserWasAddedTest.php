<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Users\Domain\Events;

use function Safe\json_encode;
use PHPUnit\Framework\TestCase;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Events\UserWasAdded;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\UserId;

final class UserWasAddedTest extends TestCase
{
    public function testSerialises(): void
    {
        $event = new UserWasAdded(
            new Email('peterwsomerville@gmail.com'),
            new Name('Peter Somerville'),
            UserId::generate(),
        );

        /** @var string $serialised */
        $serialised = json_encode($event);

        $this->assertEquals($event, UserWasAdded::deserialize($serialised));
    }
}
