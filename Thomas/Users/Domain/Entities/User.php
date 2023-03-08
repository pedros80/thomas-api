<?php

declare(strict_types=1);

namespace Thomas\Users\Domain\Entities;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Contracts\Auth\Authenticatable;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Events\UserWasAdded;
use Thomas\Users\Domain\Events\UserWasReinstated;
use Thomas\Users\Domain\Events\UserWasRemoved;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\RemovedAt;
use Thomas\Users\Domain\UserId;

final class User extends EventSourcedAggregateRoot implements Authenticatable
{
    use AuthAuthenticatable;

    private Email $email;
    private Name $name;
    private UserId $userId;
    private ?RemovedAt $removedAt = null;

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

    public function remove(RemovedAt $removedAt): void
    {
        $this->apply(
            new UserWasRemoved($this->email, $this->userId, $removedAt)
        );
    }

    public function applyUserWasRemoved(UserWasRemoved $event): void
    {
        $this->removedAt = $event->removedAt();
    }

    public function reinstate(
        Name $name,
        UserId $userId
    ): void {
        $this->apply(
            new UserWasReinstated($this->email, $this->userId, $name, $userId)
        );
    }

    public function applyUserWasReinstated(UserWasReinstated $event): void
    {
        $this->removedAt = null;
        $this->name      = $event->name();
        $this->userId    = $event->userId();
    }

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

    public function removedAt(): ?RemovedAt
    {
        return $this->removedAt;
    }
}
