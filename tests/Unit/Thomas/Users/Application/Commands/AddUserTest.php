<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Users\Application\Commands;

use PHPUnit\Framework\TestCase;
use Thomas\Users\Application\Commands\AddUser;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\UserId;

final class AddUserTest extends TestCase
{
    public function testInstantiates(): void
    {
        $userId = UserId::generate();

        $command = new AddUser(
            new Email('peterwsomerville@gmail.com'),
            new Name('Peter Somerville'),
            $userId,
        );

        $this->assertEquals([
            'email'  => 'peterwsomerville@gmail.com',
            'name'   => 'Peter Somerville',
            'userId' => (string) $userId,
        ], $command->toArray());
    }
}
