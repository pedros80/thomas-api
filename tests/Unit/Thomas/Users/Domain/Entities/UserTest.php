<?php

namespace Tests\Unit\Thomas\Users\Domain\Entities;

use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Entities\User;
use Thomas\Users\Domain\Events\UserWasRegistered;
use Thomas\Users\Domain\Events\UserWasVerified;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\Password;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Domain\VerifyToken;

final class UserTest extends AggregateRootScenarioTestCase
{
    protected function getAggregateRootClass(): string
    {
        return User::class;
    }

    public function testUserCanBeRegistered(): void
    {
        $passwordHash = Password::generate()->hash();
        $userId       = UserId::generate();
        $verifyToken  = VerifyToken::fromUserId($userId);

        $this->scenario->when(fn () => User::register(
            new Email('peterwsomerville@gmail.com'),
            new Name('Peter Somerville'),
            $passwordHash,
            $userId,
            $verifyToken
        ))->then([
            new UserWasRegistered(
                new Email('peterwsomerville@gmail.com'),
                new Name('Peter Somerville'),
                $passwordHash,
                $userId,
                $verifyToken
            ),
        ]);
    }

    public function testRegisteredUserCanBeVerified(): void
    {
        $passwordHash = Password::generate()->hash();
        $userId       = UserId::generate();
        $verifyToken  = VerifyToken::fromUserId($userId);

        $this->scenario
            ->withAggregateId(new Email('peterwsomerville@gmail.com'))
            ->given([
                new UserWasRegistered(
                    new Email('peterwsomerville@gmail.com'),
                    new Name('Peter Somerville'),
                    $passwordHash,
                    $userId,
                    $verifyToken
                ),
            ])->when(fn (User $user) => $user->verify($verifyToken))
            ->then([
                new UserWasVerified(
                    new Email('peterwsomerville@gmail.com'),
                    $verifyToken,
                    $userId
                )
            ]);
    }
}
