<?php

declare(strict_types=1);

namespace App\Console\Commands\Users;

use Illuminate\Console\Command;
use Thomas\Shared\Application\CommandBus;
use Thomas\Users\Application\Commands\RemoveUser;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\RemovedAt;

final class RemoveUserByEmail extends Command
{
    protected $signature   = 'users:remove {email? : The email of the user to remove}';
    protected $description = 'Remove a user';

    public function handle(CommandBus $commandBus): void
    {
        $email = new Email($this->getEmail());
        $commandBus->dispatch(new RemoveUser($email, RemovedAt::now()));

        $this->info("Command to delete {$email} has been dispatched");
    }

    private function getEmail(): string
    {
        $email = $this->argument('email') ?: $this->ask("Please enter user's email address:");

        return is_array($email) ? $email[0] : $email;
    }
}
