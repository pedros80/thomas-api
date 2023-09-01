<?php

declare(strict_types=1);

namespace Tests\Feature\App\Console\Commands\Stations;

use Illuminate\Testing\PendingCommand;
use Tests\TestCase;
use Thomas\Shared\Domain\CRS;

final class StationMessagesCommandsTest extends TestCase
{
    public function testAddMessageWithStationsReturnsSuccess(): void
    {
        /** @var PendingCommand $command */
        $command = $this->artisan('stations:add-message');
        $command
            ->expectsQuestion('How many Stations to include in message?', '2')
            ->expectsOutput('Message routed: includes 2 stations.')
            ->assertSuccessful();
    }

    public function testGetMessagesReturnsSuccess(): void
    {
        $code = array_keys(CRS::list())[0];
        $name = CRS::fromString($code)->name();

        /** @var PendingCommand $command */
        $command = $this->artisan('stations:get-messages');
        $command
            ->expectsQuestion('Which Station Code?', $code)
            ->expectsTable(
                ['ID', 'Category', 'Severity', 'Body', 'Station'],
                [
                    [
                        '123606',
                        'Train',
                        'minor',
                        'The lifts are out of order between Platforms 1 and 2 and the footbridge at St Neots station.',
                        $name,
                    ],
                ]
            )
            ->assertSuccessful();
    }

    public function testGetNoMessagesReturnsSuccess(): void
    {
        /** @var PendingCommand $command */
        $command = $this->artisan('stations:get-messages');
        $command
            ->expectsQuestion('Which Station Code?', 'DAM')
            ->expectsOutput('No messages found for Dalmeny')
            ->assertSuccessful();
    }

    public function testRemoveKnownMessageReturnsSuccess(): void
    {
        /** @var PendingCommand $command */
        $command = $this->artisan('stations:remove-message');
        $command
            ->expectsQuestion('Which Station Message ID?', '123606')
            ->expectsOutput('Command to remove message dispatched...')
            ->assertSuccessful();
    }

    public function testAddMessageWithoutStationsReturnsSuccess(): void
    {
        /** @var PendingCommand $command */
        $command = $this->artisan('stations:add-message');
        $command
            ->expectsQuestion('How many Stations to include in message?', '1')
            ->expectsOutput('Message routed: includes 1 station.')
            ->assertSuccessful();

        /** @var PendingCommand $command */
        $command = $this->artisan('stations:add-message');
        $command
            ->expectsQuestion('How many Stations to include in message?', '0')
            ->expectsOutput('Message routed: includes 0 stations.')
            ->assertSuccessful();
    }
}
