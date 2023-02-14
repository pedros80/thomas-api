<?php

namespace Thomas\Users\Application\Commands\Handlers;

use Broadway\CommandHandling\SimpleCommandHandler;
use Thomas\Shared\Application\CommandHandler;
use Thomas\Shared\Infrastructure\Exceptions\EventStreamNotFound;
use Thomas\Users\Application\Commands\RegisterUser;
use Thomas\Users\Domain\Entities\User;
use Thomas\Users\Domain\Exceptions\EmailAlreadyRegistered;
use Thomas\Users\Domain\Exceptions\UserNotFound;
use Thomas\Users\Domain\UsersRepository;

final class RegisterUserCommandHandler extends SimpleCommandHandler implements CommandHandler
{
    public function __construct(
        private UsersRepository $users
    ) {
    }

    public function handleRegisterUser(RegisterUser $command): void
    {
        try {
            $this->users->find($command->email());

            throw EmailAlreadyRegistered::fromEmail($command->email());
        } catch (EventStreamNotFound | UserNotFound) {
            $user = User::register(
                $command->email(),
                $command->name(),
                $command->passwordHash(),
                $command->userId(),
                $command->verifyToken()
            );

            $this->users->save($user);
        }
    }
}
