<?php

namespace Thomas\Users\Application\Commands\Handlers;

use Broadway\CommandHandling\SimpleCommandHandler;
use Thomas\Shared\Application\CommandHandler;
use Thomas\Shared\Infrastructure\Exceptions\EventStreamNotFound;
use Thomas\Users\Application\Commands\RemoveUser;
use Thomas\Users\Domain\Entities\User;
use Thomas\Users\Domain\Exceptions\EmailAlreadyAdded;
use Thomas\Users\Domain\Exceptions\UserNotFound;
use Thomas\Users\Domain\UsersRepository;

final class RemoveUserCommandHandler extends SimpleCommandHandler implements CommandHandler
{
    public function __construct(
        private UsersRepository $users
    ) {
    }

    public function handleRemoveUser(RemoveUser $command): void
    {
        $user = $this->users->find($command->email());

        $user->remove();

        $this->users->save($user);
    }
}
