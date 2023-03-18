<?php

declare(strict_types=1);

namespace App\Console\Commands\Users;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Console\Command;
use Thomas\Shared\Application\CommandBus;
use Thomas\Users\Application\Commands\AddUser;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\UserId;

final class AddNewUser extends Command
{
    public $signature   = 'users:add {email? : Override Email?}';
    public $description = 'Add a user';

    public function handle(CommandBus $commandBus):  void
    {
        $faker = Factory::create();

        $email  = $this->getEmail($faker);
        $name   = new Name($faker->name());
        $userId = UserId::generate();

        $command = new AddUser($email, $name, $userId);

        $commandBus->dispatch($command);

        $this->info('Command Dispatched to Add User.');

        $this->table([
            'Email', 'Name', 'UserID',
        ], [
            [$email, $name, $userId],
        ]);
    }

    private function getEmail(Generator $faker): Email
    {
        $email = $this->argument('email') ?: $faker->email();
        $email = is_array($email) ? $email[0] : $email;

        return new Email($email);
    }
}
