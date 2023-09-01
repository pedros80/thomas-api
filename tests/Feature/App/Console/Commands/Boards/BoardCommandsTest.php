<?php

declare(strict_types=1);

namespace Tests\Feature\App\Console\Commands\Boards;

use Illuminate\Testing\PendingCommand;
use Tests\TestCase;

final class BoardCommandsTest extends TestCase
{
    public function testGetBoardReturnsSuccessfully(): void
    {
        /** @var PendingCommand $command */
        $command = $this->artisan('board:get');
        $command
            ->expectsQuestion('Which Station?', 'DAM')
            // ->expectsOutput('Departures Board for Dalmeny')
            ->assertSuccessful();
    }
}
