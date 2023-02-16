<?php

namespace App\Console\Commands\Users;

use Faker\Factory;
use Illuminate\Console\Command;
use Thomas\Shared\Application\CommandBus;
use Thomas\Users\Application\Commands\AddUser;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\UserId;

final class AddNewUser extends Command
{
    public $signature   = 'users:add';
    public $description = 'Add a user';

    public function handle(CommandBus $commandBus):  void
    {
        $faker = Factory::create();

        $command = new AddUser(
            new Email($faker->email),
            new Name($faker->name()),
            UserId::generate(),
        );

        $commandBus->dispatch($command);

        $this->info('Command Dispatched to Add User.');
    }
}
