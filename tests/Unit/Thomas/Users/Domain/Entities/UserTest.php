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
    private Email $email;
    private Name $name;
    private RemovedAt $removedAt;
    private UserId $userId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->email     = new Email('peterwsomerville@gmail.com');
        $this->name      = new Name('Peter Somerville');
        $this->removedAt = RemovedAt::now();
        $this->userId    = UserId::generate();
    }

    protected function getAggregateRootClass(): string
    {
        return User::class;
    }

    public function testUserCanBeAdded(): void
    {
        $this->scenario
            ->when(fn () => User::add($this->email, $this->name, $this->userId))
            ->then([
                $this->makeUserWasAdded(),
            ]);
    }

    public function testUserCanBeRemoved(): void
    {
        $this->scenario
            ->withAggregateId((string) $this->email)
            ->given([
                $this->makeUserWasAdded(),
            ])->when(
                fn (User $user) => $user->remove($this->removedAt)
            ) ->then([
                $this->makeUserWasRemoved(),
            ]);
    }

    public function testUserCanBeReinstated(): void
    {
        $this->scenario
            ->withAggregateId((string) $this->email)
            ->given([
                $this->makeUserWasAdded(),
                $this->makeUserWasRemoved(),
            ])->when(
                fn (User $user) => $user->reinstate($this->name, $this->userId)
            )->then([
                $this->makeUserWasReinstated(),
            ]);
    }

    private function makeUserWasAdded(): UserWasAdded
    {
        return new UserWasAdded(
            $this->email,
            $this->name,
            $this->userId,
        );
    }

    private function makeUserWasRemoved(): UserWasRemoved
    {
        return new UserWasRemoved(
            $this->email,
            $this->userId,
            $this->removedAt,
        );
    }

    private function makeUserWasReinstated(): UserWasReinstated
    {
        return new UserWasReinstated(
            $this->email,
            $this->userId,
            $this->name,
            $this->userId,
        );
    }
}
