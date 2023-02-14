<?php

namespace App\Console\Commands\Users;

use Faker\Factory;
use Illuminate\Console\Command;
use Thomas\Shared\Application\CommandBus;
use Thomas\Users\Application\Commands\RegisterUser;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\Password;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Domain\VerifyToken;

final class RegisterNewUser extends Command
{
    public $signature   = 'users:register';
    public $description = 'Register a user';

    public function handle(CommandBus $commandBus):  void
    {
        $faker = Factory::create();

        $userId = new UserId('01GS8V8DP8HAD890QBV282XFG7');
        $vt = VerifyToken::fromUserId($userId);

        $command = new RegisterUser(
            new Email($faker->email()),
            new Name($faker->name()),
            Password::generate(),
            $userId,
            new VerifyToken('69bac1d0f86fd7995b3619cbc32d37945e3d657d')
        );

        $commandBus->dispatch($command);

        $this->info('Command Dispatched to Register User.');
    }
}
