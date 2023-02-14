<?php

namespace App\Console\Commands\Users;

use Illuminate\Console\Command;
use Thomas\Shared\Application\CommandBus;
use Thomas\Users\Application\Commands\VerifyUser as CommandsVerifyUser;
use Thomas\Users\Application\Queries\GetEmailFromUserIdAndVerifyToken;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Domain\VerifyToken;

final class VerifyUser extends Command
{
    protected $signature   = 'users:verify';
    protected $description = 'Verify user';

    public function handle(CommandBus $commandBus, GetEmailFromUserIdAndVerifyToken $query): void
    {
        $userId      = new UserId('01GS8V8DP8HAD890QBV282XFG7');
        $verifyToken = new VerifyToken('69bac1d0f86fd7995b3619cbc32d37945e3d657d');

        $email = $query->get($userId, $verifyToken);

        $commandBus->dispatch(new CommandsVerifyUser($email, $verifyToken));

        $this->info('Command Dispatched to Verify User.');
    }
}
