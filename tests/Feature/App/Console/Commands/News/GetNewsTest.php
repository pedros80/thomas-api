<?php

declare(strict_types=1);

namespace Tests\Feature\App\Console\Commands\News;

use Illuminate\Testing\PendingCommand;
use Tests\TestCase;

final class GetNewsTest extends TestCase
{
    public function testCommandExistsSuccessfully(): void
    {
        /** @var PendingCommand $command */
        $command = $this->artisan('news:get');
        $command->assertSuccessful();
    }
}
