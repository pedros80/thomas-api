<?php

namespace Thomas\Stations\Application\Commands\Handlers;

use Broadway\CommandHandling\SimpleCommandHandler;
use Thomas\Shared\Application\CommandHandler;
use Thomas\Shared\Infrastructure\Exceptions\EventStreamNotFound;
use Thomas\Stations\Application\Commands\RecordStationMessage;
use Thomas\Stations\Domain\Entities\Message;
use Thomas\Stations\Domain\Exceptions\MessageNotFound;
use Thomas\Stations\Domain\MessagesRepository;

final class RecordStationMessageCommandHandler extends SimpleCommandHandler implements CommandHandler
{
    public function __construct(
        private MessagesRepository $messages
    ) {
    }

    public function handleRecordStationMessage(RecordStationMessage $command): void
    {
        try {
            $message = $this->messages->find($command->id());
            $message->update(
                $command->id(),
                $command->category(),
                $command->body(),
                $command->severity(),
                $command->stations()
            );

            $this->messages->save($message);
        } catch (EventStreamNotFound | MessageNotFound) {
            $message = Message::add(
                $command->id(),
                $command->category(),
                $command->body(),
                $command->severity(),
                $command->stations()
            );
            $this->messages->save($message);
        }
    }
}
