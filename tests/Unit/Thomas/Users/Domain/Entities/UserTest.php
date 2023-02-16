<?php

namespace Tests\Unit\Thomas\Users\Domain\Entities;

use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Entities\User;
use Thomas\Users\Domain\Events\UserWasAdded;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\UserId;

final class UserTest extends AggregateRootScenarioTestCase
{
    protected function getAggregateRootClass(): string
    {
        return User::class;
    }

    public function testUserCanBeAdded(): void
    {
        $userId = UserId::generate();
        $email  = new Email('peterwsomerville@gmail.com');
        $name   = new Name('Peter Somerville');

        $this->scenario
            ->when(fn () => User::add($email, $name, $userId))
            ->then([new UserWasAdded($email, $name, $userId)]);
    }
}
