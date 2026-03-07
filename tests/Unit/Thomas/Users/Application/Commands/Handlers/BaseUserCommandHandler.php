<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Users\Application\Commands\Handlers;

use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Thomas\Users\Application\Commands\AddUser;
use Thomas\Users\Application\Commands\RemoveUser;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Events\UserWasAdded;
use Thomas\Users\Domain\Events\UserWasReinstated;
use Thomas\Users\Domain\Events\UserWasRemoved;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\RemovedAt;
use Thomas\Users\Domain\UserId;

abstract class BaseUserCommandHandler extends CommandHandlerScenarioTestCase
{
    protected UserId $userId;
    protected Email $email;
    protected Name $name;
    protected RemovedAt $removedAt;

    public function setUp(): void
    {
        parent::setUp();

        $this->userId = UserId::generate();
        $this->email  = new Email('peterwsomerville@gmail.com');
        $this->name   = new Name('Peter Somerville');
        $this->removedAt = RemovedAt::now();
    }

    protected function makeAddUser(): AddUser
    {
        return new AddUser(
            $this->email,
            $this->name,
            $this->userId,
        );
    }

    protected function makeRemoveUser(): RemoveUser
    {
        return new RemoveUser(
            $this->email,
            $this->removedAt,
        );
    }

    protected function makeUserWasAdded(): UserWasAdded
    {
        return new UserWasAdded(
            $this->email,
            $this->name,
            $this->userId,
        );
    }

    protected function makeUserWasRemoved(): UserWasRemoved
    {
        return new UserWasRemoved(
            $this->email,
            $this->userId,
            $this->removedAt,
        );
    }

    protected function makeUserWasReinstated(): UserWasReinstated
    {
        return new UserWasReinstated(
            $this->email,
            $this->userId,
            $this->name,
            $this->userId,
        );
    }
}
