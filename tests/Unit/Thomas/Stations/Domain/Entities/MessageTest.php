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
use Thomas\Stations\Domain\MessageId;
use Thomas\Stations\Domain\MessageSeverity;
use Thomas\Stations\Domain\Stations;

final class MessageTest extends AggregateRootScenarioTestCase
{
    private MessageId $messageId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->messageId = new MessageId('12345');
    }

    protected function getAggregateRootClass(): string
    {
        return Message::class;
    }

    public function testCanAddMessage(): void
    {
        $this->scenario->when(fn () => Message::add(
            $this->messageId,
            MessageCategory::TRAIN,
            new MessageBody('MESSAGE_BODY'),
            MessageSeverity::MAJOR,
            Stations::fromArray([])
        ))->then([
            $this->makeMessageWasAdded(),
        ]);
    }

    public function testCanRemoveExistingMessage(): void
    {
        $this->scenario
            ->withAggregateId((string) $this->messageId)
            ->given([
                $this->makeMessageWasAdded(),
            ])->when(
                fn (Message $message) => $message->remove()
            )->then([
                $this->makeMessageWasRemoved(),
            ]);
    }

    public function testCanUpdateMessage(): void
    {
        $this->scenario
            ->withAggregateId((string) $this->messageId)
            ->given([
                $this->makeMessageWasAdded(),
            ])->when(fn (Message $message) => $message->update(
                $this->messageId,
                MessageCategory::TRAIN,
                new MessageBody('MESSAGE_BODY'),
                MessageSeverity::MAJOR,
                Stations::fromArray([])
            ))->then([
                $this->makeMessageWasUpdated(),
            ]);
    }

    private function makeMessageWasAdded(): MessageWasAdded
    {
        return new MessageWasAdded(
            $this->messageId,
            MessageCategory::TRAIN,
            new MessageBody('MESSAGE_BODY'),
            MessageSeverity::MAJOR,
            Stations::fromArray([]),
        );
    }

    private function makeMessageWasUpdated(): MessageWasUpdated
    {
        return new MessageWasUpdated(
            $this->messageId,
            MessageCategory::TRAIN,
            new MessageBody('MESSAGE_BODY'),
            MessageSeverity::MAJOR,
            Stations::fromArray([]),
        );
    }

    private function makeMessageWasRemoved(): MessageWasRemoved
    {
        return new MessageWasRemoved($this->messageId);
    }
}
