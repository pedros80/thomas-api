<?php

namespace Tests\Feature\App\Console\Commands\Users;

use Tests\TestCase;

final class VerifyUserTest extends TestCase
{
    public function testCanRegisterUser(): void
    {
        /** @var PendingCommand $command */
        $command = $this->artisan('users:verify');
        $command
            ->expectsOutput('Command Dispatched to Verify User.')
            ->assertSuccessful();
    }
}
