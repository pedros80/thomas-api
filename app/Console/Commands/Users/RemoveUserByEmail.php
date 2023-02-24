<?php

namespace App\Console\Commands\Users;

use Illuminate\Console\Command;
use Thomas\Shared\Application\CommandBus;
use Thomas\Users\Application\Commands\RemoveUser;
use Thomas\Users\Domain\Email;

final class RemoveUserByEmail extends Command
{
    protected $signature = 'users:remove {email : The email of the user to remove}';
    protected $description = 'Remove a user';

    public function handle(CommandBus $commandBus): void
    {
        $email = new Email($this->argument('email'));

        $command = new RemoveUser($email);

        $commandBus->dispatch($command);
    }
}