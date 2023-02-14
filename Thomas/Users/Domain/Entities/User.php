<?php

namespace Thomas\Users\Domain\Entities;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Events\UserWasRegistered;
use Thomas\Users\Domain\Events\UserWasVerified;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\PasswordHash;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Domain\VerifyToken;

final class User extends EventSourcedAggregateRoot
{
    private Email $email;
    private Name $name;
    private PasswordHash $passwordHash;
    private UserId $userId;
    private VerifyToken $verifyToken;
    private bool $verifed = false;

    public static function register(
        Email $email,
        Name $name,
        PasswordHash $passwordHash,
        UserId $userId,
        VerifyToken $verifyToken
    ): User {
        $user = new User();

        $user->apply(
            new UserWasRegistered(
                $email,
                $name,
                $passwordHash,
                $userId,
                $verifyToken
            )
        );

        return $user;
    }

    public function applyUserWasRegistered(UserWasRegistered $event): void
    {
        $this->email        = $event->email();
        $this->name         = $event->name();
        $this->passwordHash = $event->passwordHash();
        $this->userId       = $event->userId();
        $this->verifyToken  = $event->verifyToken();
    }

    public function verify(VerifyToken $verifyToken): void
    {
        $this->apply(
            new UserWasVerified(
                $this->email,
                $verifyToken,
                $this->userId
            )
        );
    }

    public function applyUserWasVerified(UserWasVerified $event): void
    {
        $this->verifed = true;
    }

    public function getAggregateRootId(): string
    {
        return (string) $this->email;
    }
}
