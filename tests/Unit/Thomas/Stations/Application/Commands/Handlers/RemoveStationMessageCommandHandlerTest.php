<?php

namespace Tests\Unit\Thomas\Stations\Application\Commands\Handlers;

use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Thomas\Stations\Application\Commands\Handlers\RemoveStationMessageCommandHandler;
use Thomas\Stations\Application\Commands\RemoveStationMessage;
use Thomas\Stations\Domain\Code;
use Thomas\Stations\Domain\Events\MessageWasAdded;
use Thomas\Stations\Domain\Events\MessageWasRemoved;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageID;
use Thomas\Stations\Domain\MessageSeverity;
use Thomas\Stations\Domain\Name;
use Thomas\Stations\Domain\Station;
use Thomas\Stations\Infrastructure\BroadwayRepository;

final class RemoveStationMessageCommandHandlerTest extends CommandHandlerScenarioTestCase
{
    public function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new RemoveStationMessageCommandHandler(new BroadwayRepository($eventStore, $eventBus));
    }

    public function testExistingStationMessageCanBeRemoved(): void
    {
        $this->scenario
            ->withAggregateId(new MessageID('12345'))
            ->given([
                new MessageWasAdded(
                    new MessageID('12345'),
                    new MessageCategory(MessageCategory::TRAIN),
                    new MessageBody('MESSAGE BODY'),
                    new MessageSeverity(MessageSeverity::MAJOR),
                    [
                        new Station(new Code('DAM'), new Name('Dalmeny')),
                    ]
                ),
            ])
            ->when(new RemoveStationMessage(new MessageID('12345')))
            ->then([new MessageWasRemoved(new MessageID('12345'))]);
    }

    public function testAttemptingRemovingNoMessageDoesNothing(): void
    {
        $this->scenario
            ->given([])
            ->when(new RemoveStationMessage(new MessageID('12345')))
            ->then([]);
    }
}
