<?php

namespace Thomas\Users\Domain\Entities;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Contracts\Auth\Authenticatable;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Events\UserWasAdded;
use Thomas\Users\Domain\Events\UserWasRemoved;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\UserId;

final class User extends EventSourcedAggregateRoot implements Authenticatable
{
    use AuthAuthenticatable;

    private Email $email;
    private Name $name;
    private UserId $userId;

    public static function add(
        Email $email,
        Name $name,
        UserId $userId,
    ): User {
        $user = new User();

        $user->apply(new UserWasAdded($email, $name, $userId));

        return $user;
    }

    public function applyUserWasAdded(UserWasAdded $event): void
    {
        $this->email  = $event->email();
        $this->name   = $event->name();
        $this->userId = $event->userId();
    }

    public function remove(): void
    {
        $this->apply(
            new UserWasRemoved($this->email, $this->userId)
        );
    }

    // @todo applyUserWasRemoved. timestamps for entities??


    public function getAggregateRootId(): string
    {
        return (string) $this->email;
    }

    public function getKeyName(): string
    {
        return 'email';
    }

    public function userId(): UserId
    {
        return $this->userId;
    }
}
