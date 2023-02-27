<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Application\Commands\Handlers;

use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Thomas\Stations\Application\Commands\Handlers\RecordStationMessageCommandHandler;
use Thomas\Stations\Application\Commands\RecordStationMessage;
use Thomas\Stations\Domain\Code;
use Thomas\Stations\Domain\Events\MessageWasAdded;
use Thomas\Stations\Domain\Events\MessageWasUpdated;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageID;
use Thomas\Stations\Domain\MessageSeverity;
use Thomas\Stations\Domain\Name;
use Thomas\Stations\Domain\Station;
use Thomas\Stations\Infrastructure\BroadwayRepository;

final class RecordStationMessageCommandHandlerTest extends CommandHandlerScenarioTestCase
{
    public function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new RecordStationMessageCommandHandler(new BroadwayRepository($eventStore, $eventBus));
    }

    public function testExistingStationMessageCanBeUpdated(): void
    {
        $this->scenario
            ->withAggregateId((string) new MessageID('12345'))
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
            ->when(
                new RecordStationMessage(
                    new MessageID('12345'),
                    new MessageCategory(MessageCategory::TRAIN),
                    new MessageBody('MESSAGE BODY'),
                    new MessageSeverity(MessageSeverity::MAJOR),
                    []
                )
            )->then([
                new MessageWasUpdated(
                    new MessageID('12345'),
                    new MessageCategory(MessageCategory::TRAIN),
                    new MessageBody('MESSAGE BODY'),
                    new MessageSeverity(MessageSeverity::MAJOR),
                    []
                ),
            ]);
    }

    public function testNewStationMessageCanBeRecordeed(): void
    {
        $this->scenario
            ->given([])
            ->when(
                new RecordStationMessage(
                    new MessageID('12345'),
                    new MessageCategory(MessageCategory::TRAIN),
                    new MessageBody('MESSAGE BODY'),
                    new MessageSeverity(MessageSeverity::MAJOR),
                    []
                )
            )->then([
                new MessageWasAdded(
                    new MessageID('12345'),
                    new MessageCategory(MessageCategory::TRAIN),
                    new MessageBody('MESSAGE BODY'),
                    new MessageSeverity(MessageSeverity::MAJOR),
                    []
                ),
            ]);
    }
}
