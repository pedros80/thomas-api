<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Application\Commands\Handlers;

use Broadway\CommandHandling\CommandHandler;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Thomas\Stations\Application\Commands\Handlers\RecordStationMessageCommandHandler;
use Thomas\Stations\Application\Commands\RecordStationMessage;
use Thomas\Stations\Domain\Events\MessageWasUpdated;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageSeverity;
use Thomas\Stations\Domain\Stations;
use Thomas\Stations\Infrastructure\BroadwayRepository;
use Tests\Unit\Thomas\Stations\Application\Commands\Handlers\BaseStationMessageCommandHandler;

final class RecordStationMessageCommandHandlerTest extends BaseStationMessageCommandHandler
{
    public function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new RecordStationMessageCommandHandler(new BroadwayRepository($eventStore, $eventBus));
    }

    public function testExistingStationMessageCanBeUpdated(): void
    {
        $this->scenario
            ->withAggregateId((string) $this->messageId)
            ->given([
                $this->makeMessageWasAdded(),
            ])->when(
                $this->makeRecordStationMessage(),
            )->then([
                $this->makeMessageWasUpdated(),
            ]);
    }

    public function testNewStationMessageCanBeRecordeed(): void
    {
        $this->scenario
            ->given([])
            ->when(
                $this->makeRecordStationMessage(),
            )->then([
                $this->makeMessageWasAdded(),
            ]);
    }

    private function makeRecordStationMessage(): RecordStationMessage
    {
        return new RecordStationMessage(
            $this->messageId,
            MessageCategory::TRAIN,
            new MessageBody('MESSAGE BODY'),
            MessageSeverity::MAJOR,
            Stations::fromArray([]),
        );
    }

    private function makeMessageWasUpdated(): MessageWasUpdated
    {
        return new MessageWasUpdated(
            $this->messageId,
            MessageCategory::TRAIN,
            new MessageBody('MESSAGE BODY'),
            MessageSeverity::MAJOR,
            Stations::fromArray([]),
        );
    }
}
