<?php

namespace Thomas\Users\Application\Commands\Handlers;

use Broadway\CommandHandling\SimpleCommandHandler;
use Thomas\Shared\Application\CommandHandler;
use Thomas\Users\Application\Commands\VerifyUser;
use Thomas\Users\Domain\UsersRepository;

final class VerifyUserCommandHandler extends SimpleCommandHandler implements CommandHandler
{
    public function __construct(
        private UsersRepository $users
    ) {
    }

    public function handleVerifyUser(VerifyUser $command): void
    {
        $user = $this->users->find($command->email());

        $user->verify($command->verifyToken());

        $this->users->save($user);
    }
}
