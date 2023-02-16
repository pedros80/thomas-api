<?php

namespace Thomas\Users\Application\Commands\Handlers;

use Broadway\CommandHandling\SimpleCommandHandler;
use Thomas\Shared\Application\CommandHandler;
use Thomas\Shared\Infrastructure\Exceptions\EventStreamNotFound;
use Thomas\Users\Application\Commands\AddUser;
use Thomas\Users\Domain\Entities\User;
use Thomas\Users\Domain\Exceptions\EmailAlreadyAdded;
use Thomas\Users\Domain\Exceptions\UserNotFound;
use Thomas\Users\Domain\UsersRepository;

final class AddUserCommandHandler extends SimpleCommandHandler implements CommandHandler
{
    public function __construct(
        private UsersRepository $users
    ) {
    }

    public function handleAddUser(AddUser $command): void
    {
        try {
            $this->users->find($command->email());

            throw EmailAlreadyAdded::fromEmail($command->email());
        } catch (EventStreamNotFound | UserNotFound) {
            $user = User::add(
                $command->email(),
                $command->name(),
                $command->userId(),
            );

            $this->users->save($user);
        }
    }
}
