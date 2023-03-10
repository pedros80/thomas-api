<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Users\Domain\Entities;

use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Entities\User;
use Thomas\Users\Domain\Events\UserWasAdded;
use Thomas\Users\Domain\Events\UserWasReinstated;
use Thomas\Users\Domain\Events\UserWasRemoved;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\RemovedAt;
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

    public function testUserCanBeRemoved(): void
    {
        $userId    = UserId::generate();
        $email     = new Email('peterwsomerville@gmail.com');
        $name      = new Name('Peter Somerville');
        $removedAt = RemovedAt::now();

        $this->scenario
            ->withAggregateId((string) $email)
            ->given([new UserWasAdded($email, $name, $userId)])
            ->when(fn (User $user) => $user->remove($removedAt))
            ->then([new UserWasRemoved($email, $userId, $removedAt)]);
    }

    public function testUserCanBeReinstated(): void
    {
        $userId    = UserId::generate();
        $email     = new Email('peterwsomerville@gmail.com');
        $name      = new Name('Peter Somerville');
        $removedAt = RemovedAt::now();

        $this->scenario
            ->withAggregateId((string) $email)
            ->given([new UserWasAdded($email, $name, $userId), new UserWasRemoved($email, $userId, $removedAt)])
            ->when(fn (User $user) => $user->reinstate($name, $userId))
            ->then([new UserWasReinstated($email, $userId, $name, $userId)]);
    }
}
