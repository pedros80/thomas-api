<?php

declare(strict_types=1);

namespace Tests\Feature\App\Console\Commands\RealTimeIncidents;

use Illuminate\Testing\PendingCommand;
use Tests\TestCase;
use Thomas\Shared\Infrastructure\Exceptions\DuplicatePlayhead;

final class RealTimeIncidentsCommandsTest extends TestCase
{
    public function testAddRTI(): void
    {
        /** @var PendingCommand $command */
        $command = $this->artisan('rti:add');
        $command
            ->expectsOutput('Command to add RTI dispatched.')
            ->assertSuccessful();
    }

    public function testAddDuplicateThrowsException(): void
    {
        $this->expectException(DuplicatePlayhead::class);

        $this->expectExceptionMessage('Duplicate Playhead in this event stream');
        /** @var PendingCommand $command */
        $command = $this->artisan('rti:add');
        $command->assertFailed();
    }

    public function testGetRTI(): void
    {
        /** @var PendingCommand $command */
        $command = $this->artisan('rti:get');
        $command
            ->expectsTable(['ID', 'STATUS', 'SUMMARY', 'OPERATORS'], [
                [
                    'D85AA5FB1954428C84A2F636014C2A4A',
                    'NEW',
                    'Delays between London St Pancras International and St Albans expected until 11:30',
                    'TL',
                ],
            ])
            ->assertSuccessful();
    }

    public function testUpdateRTI(): void
    {
        /** @var PendingCommand $command */
        $command = $this->artisan('rti:update');
        $command
            ->expectsOutput('Command dispatched to update rti.')
            ->assertSuccessful();
    }

    public function testRemoveRTI(): void
    {
        /** @var PendingCommand $command */
        $command = $this->artisan('rti:remove');
        $command
            ->expectsOutput('Command dispatched to remove rti.')
            ->assertSuccessful();
    }
}
