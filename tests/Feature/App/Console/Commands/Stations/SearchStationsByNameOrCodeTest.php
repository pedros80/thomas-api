<?php

declare(strict_types=1);

namespace Tests\Feature\App\Console\Commands\Stations;

use Illuminate\Testing\PendingCommand;
use Tests\TestCase;

final class SearchStationsByNameOrCodeTest extends TestCase
{
    public function testSingularSearchTermExitsSuccessfully(): void
    {
        /** @var PendingCommand $command */
        $command = $this->artisan('stations:search');
        $command->expectsQuestion('Enter Search Term?', 'dalmeny')
            ->expectsOutput('Found 1 Station')
            ->expectsTable(['Code', 'Name'], [['DAM', 'Dalmeny']])
            ->assertSuccessful();
    }

    public function testUnfoundSearchTermExistsSuccessfully(): void
    {
        /** @var PendingCommand $command */
        $command = $this->artisan('stations:search');
        $command->expectsQuestion('Enter Search Term?', 'blahblahblah')
        ->expectsOutput('Found 0 Stations')
        ->assertSuccessful();
    }
}
