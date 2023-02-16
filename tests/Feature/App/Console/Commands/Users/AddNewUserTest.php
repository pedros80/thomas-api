<?php

namespace Tests\Feature\App\Console\Commands\Users;

use Illuminate\Testing\PendingCommand;
use Tests\TestCase;

final class AddNewUserTest extends TestCase
{
    public function testCanAddUser(): void
    {
        /** @var PendingCommand $command */
        $command = $this->artisan('users:add');
        $command
            ->expectsOutput('Command Dispatched to Add User.')
            ->assertSuccessful();
    }
}
