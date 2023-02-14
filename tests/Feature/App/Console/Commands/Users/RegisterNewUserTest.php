<?php

namespace Tests\Feature\App\Console\Commands\Users;

use Tests\TestCase;

final class RegisterNewUserTest extends TestCase
{
    public function testCanRegisterUser(): void
    {
        /** @var PendingCommand $command */
        $command = $this->artisan('users:register');
        $command
            ->expectsOutput('Command Dispatched to Register User.')
            ->assertSuccessful();
    }
}
