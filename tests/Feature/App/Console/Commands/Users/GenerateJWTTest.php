<?php

declare(strict_types=1);

namespace Tests\Feature\App\Console\Commands\Users;

use Illuminate\Testing\PendingCommand;
use Tests\TestCase;

final class GenerateJWTTest extends TestCase
{
    public function testCommandReturnsSuccess(): void
    {
        /** @var PendingCommand $command */
        $command = $this->artisan('users:jwt');
        $command->assertSuccessful();
    }
}
