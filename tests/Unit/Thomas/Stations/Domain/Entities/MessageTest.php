<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Domain\Entities;

use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Thomas\Stations\Domain\Entities\Message;
use Thomas\Stations\Domain\Events\MessageWasAdded;
use Thomas\Stations\Domain\Events\MessageWasRemoved;
use Thomas\Stations\Domain\Events\MessageWasUpdated;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageID;
use Thomas\Stations\Domain\MessageSeverity;

final class MessageTest extends AggregateRootScenarioTestCase
{
    protected function getAggregateRootClass(): string
    {
        return Message::class;
    }

    public function testCanAddMessage(): void
    {
        $this->scenario->when(fn () => Message::add(
            new MessageID('12345'),
            new MessageCategory(MessageCategory::TRAIN),
            new MessageBody('MESSAGE_BODY'),
            new MessageSeverity(MessageSeverity::MAJOR),
            []
        ))->then([
            new MessageWasAdded(
                new MessageID('12345'),
                new MessageCategory(MessageCategory::TRAIN),
                new MessageBody('MESSAGE_BODY'),
                new MessageSeverity(MessageSeverity::MAJOR),
                []
            ),
        ]);
    }

    public function testCanRemoveExistingMessage(): void
    {
        $this->scenario
            ->withAggregateId((string) new MessageID('12345'))
            ->given([
                new MessageWasAdded(
                    new MessageID('12345'),
                    new MessageCategory(MessageCategory::TRAIN),
                    new MessageBody('MESSAGE_BODY'),
                    new MessageSeverity(MessageSeverity::MAJOR),
                    []
                ),
            ])
            ->when(fn (Message $message) => $message->remove())
            ->then([new MessageWasRemoved(new MessageID('12345'))]);
    }

    public function testCanUpdateMessage(): void
    {
        $this->scenario
            ->withAggregateId((string) new MessageID('12345'))
            ->given([
                new MessageWasAdded(
                    new MessageID('12345'),
                    new MessageCategory(MessageCategory::TRAIN),
                    new MessageBody('MESSAGE_BODY'),
                    new MessageSeverity(MessageSeverity::MAJOR),
                    []
                ),
            ])->when(fn (Message $message) => $message->update(
                new MessageID('12345'),
                new MessageCategory(MessageCategory::TRAIN),
                new MessageBody('MESSAGE_BODY'),
                new MessageSeverity(MessageSeverity::MAJOR),
                []
            ))->then([
                new MessageWasUpdated(
                    new MessageID('12345'),
                    new MessageCategory(MessageCategory::TRAIN),
                    new MessageBody('MESSAGE_BODY'),
                    new MessageSeverity(MessageSeverity::MAJOR),
                    []
                ),
            ]);
    }
}
