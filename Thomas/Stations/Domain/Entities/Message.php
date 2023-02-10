<?php

namespace Thomas\Stations\Domain\Entities;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Thomas\Stations\Domain\Events\MessageWasAdded;
use Thomas\Stations\Domain\Events\MessageWasRemoved;
use Thomas\Stations\Domain\Events\MessageWasUpdated;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageID;
use Thomas\Stations\Domain\MessageSeverity;

final class Message extends EventSourcedAggregateRoot
{
    private MessageID $id;
    private MessageCategory $category;
    private MessageBody $body;
    private MessageSeverity $severity;
    private array $stations;

    public static function add(
        MessageID $id,
        MessageCategory $category,
        MessageBody $body,
        MessageSeverity $severity,
        array $stations
    ): Message {
        $message = new Message();

        $message->apply(
            new MessageWasAdded(
                $id,
                $category,
                $body,
                $severity,
                $stations
            )
        );

        return $message;
    }

    public function applyMessageWasAdded(MessageWasAdded $event): void
    {
        $this->id       = $event->id();
        $this->category = $event->category();
        $this->body     = $event->body();
        $this->severity = $event->severity();
        $this->stations = $event->stations();
    }

    public function update(
        MessageID $id,
        MessageCategory $category,
        MessageBody $body,
        MessageSeverity $severity,
        array $stations
    ): void {
        $this->apply(
            new MessageWasUpdated(
                $id,
                $category,
                $body,
                $severity,
                $stations
            )
        );
    }

    public function applyMessageWasUpdated(MessageWasUpdated $event): void
    {
        $this->category = $event->category();
        $this->body     = $event->body();
        $this->severity = $event->severity();
        $this->stations = $event->stations();
    }

    public function remove(): void
    {
        $this->apply(
            new MessageWasRemoved($this->id)
        );
    }

    public function getAggregateRootId(): string
    {
        return (string) $this->id;
    }
}
