<?php

namespace App\Console\Commands\Stations;

use Illuminate\Console\Command;
use Thomas\Shared\Application\CommandBus;
use Thomas\Stations\Application\Commands\RemoveStationMessage as CommandsRemoveStationMessage;
use Thomas\Stations\Domain\MessageID;

final class RemoveStationMessage extends Command
{
    protected $signature   = 'stations:remove-message {id? : Which message ID?}';
    protected $description = 'Remove a message from each station';

    public function handle(CommandBus $commandBus): void
    {
        $id = $this->getId();

        $command = new CommandsRemoveStationMessage(new MessageID($id));

        $commandBus->dispatch($command);

        $this->info('Command to remove message dispatched...');
    }

    private function getId(): string
    {
        $id = $this->argument('id') ?: $this->ask('Which Station Message ID?');

        return is_array($id) ? $id[0] : $id;
    }
}
