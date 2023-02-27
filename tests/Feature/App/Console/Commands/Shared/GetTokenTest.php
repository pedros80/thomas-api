<?php

declare(strict_types=1);

namespace Tests\Feature\App\Console\Commands\Shared;

use Illuminate\Testing\PendingCommand;
use Tests\TestCase;

final class GetTokenTest extends TestCase
{
    public function testCommandExistsSuccessfully(): void
    {
        /** @var PendingCommand $command */
        $command = $this->artisan('token:get');
        $command->assertSuccessful();
    }
}
