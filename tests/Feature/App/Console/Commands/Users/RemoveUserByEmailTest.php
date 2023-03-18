<?php

declare(strict_types=1);

namespace Tests\Feature\App\Console\Commands\Users;

use Faker\Factory;
use Illuminate\Testing\PendingCommand;
use Tests\TestCase;

final class RemoveUserByEmailTest extends TestCase
{
    public function testCanRemoveAUser(): void
    {
        $faker = Factory::create();
        $email = $faker->email();
        $this->artisan('users:add', ['email' => $email]);

        /** @var PendingCommand $command */
        $command = $this->artisan('users:remove', ['email' => $email]);
        $command->expectsOutput("Command to delete {$email} has been dispatched")->assertSuccessful();
    }

    public function testCanRemoveAUserAsAskedFor(): void
    {
        $faker = Factory::create();
        $email = $faker->email();
        $this->artisan('users:add', ['email' => $email]);

        /** @var PendingCommand $command */
        $command = $this->artisan('users:remove');
        $command
            ->expectsQuestion("Please enter user's email address:", $email)
            ->expectsOutput("Command to delete {$email} has been dispatched")
            ->assertSuccessful();
    }
}
