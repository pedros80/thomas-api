<?php

declare(strict_types=1);

namespace Thomas\Users\Application\Commands\Handlers;

use Broadway\CommandHandling\SimpleCommandHandler;
use Thomas\Shared\Application\CommandHandler;
use Thomas\Users\Application\Commands\RemoveUser;
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

        $user->remove($command->removedAt());

        $this->users->save($user);
    }
}
