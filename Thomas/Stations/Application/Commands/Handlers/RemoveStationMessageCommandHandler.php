<?php

namespace Thomas\Stations\Application\Commands\Handlers;

use Broadway\CommandHandling\SimpleCommandHandler;
use Thomas\Shared\Application\CommandHandler;
use Thomas\Stations\Application\Commands\RemoveStationMessage;
use Thomas\Stations\Domain\Exceptions\MessageNotFound;
use Thomas\Stations\Domain\MessagesRepository;

final class RemoveStationMessageCommandHandler extends SimpleCommandHandler implements CommandHandler
{
    public function __construct(
        private MessagesRepository $messages
    ) {
    }

    public function handleRemoveStationMessage(RemoveStationMessage $command): void
    {
        try {
            $message = $this->messages->find($command->id());
        } catch (MessageNotFound) {
            return;
        }

        $message->remove();

        $this->messages->save($message);
    }
}
