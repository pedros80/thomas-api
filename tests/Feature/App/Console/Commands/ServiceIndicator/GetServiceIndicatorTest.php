<?php

declare(strict_types=1);

namespace Tests\Feature\App\Console\Commands\ServiceIndicator;

use Illuminate\Testing\PendingCommand;
use Tests\TestCase;

final class GetServiceIndicatorTest extends TestCase
{
    public function testCommandExistsSuccessfully(): void
    {
        /** @var PendingCommand $command */
        $command = $this->artisan('serviceIndicator:get');
        $command->assertSuccessful();
    }
}
