<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Application\Commands\Handlers;

use Broadway\CommandHandling\CommandHandler;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Thomas\Stations\Application\Commands\Handlers\RemoveStationMessageCommandHandler;
use Thomas\Stations\Application\Commands\RemoveStationMessage;
use Thomas\Stations\Domain\Events\MessageWasRemoved;
use Thomas\Stations\Infrastructure\BroadwayRepository;
use Tests\Unit\Thomas\Stations\Application\Commands\Handlers\BaseStationMessageCommandHandler;

final class RemoveStationMessageCommandHandlerTest extends BaseStationMessageCommandHandler
{
    public function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new RemoveStationMessageCommandHandler(new BroadwayRepository($eventStore, $eventBus));
    }

    public function testExistingStationMessageCanBeRemoved(): void
    {
        $this->scenario
            ->withAggregateId((string) $this->messageId)
            ->given([
                $this->makeMessageWasAdded(),
            ])->when(
                $this->makeRemoveStationMessage()
            )->then([
                $this->makeMessageWasRemoved(),
            ]);
    }

    public function testAttemptingRemovingNoMessageDoesNothing(): void
    {
        $this->scenario
            ->given([])
            ->when($this->makeRemoveStationMessage())
            ->then([]);
    }

    private function makeMessageWasRemoved(): MessageWasRemoved
    {
        return new MessageWasRemoved($this->messageId);
    }

    private function makeRemoveStationMessage(): RemoveStationMessage
    {
        return new RemoveStationMessage($this->messageId);
    }
}
