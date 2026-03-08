<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain\Entities;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Thomas\Stations\Domain\Events\MessageWasAdded;
use Thomas\Stations\Domain\Events\MessageWasRemoved;
use Thomas\Stations\Domain\Events\MessageWasUpdated;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageId;
use Thomas\Stations\Domain\MessageSeverity;
use Thomas\Stations\Domain\Stations;

final class Message extends EventSourcedAggregateRoot
{
    private MessageId $id;
    private MessageCategory $category;
    private MessageBody $body;
    private MessageSeverity $severity;
    private Stations $stations;

    public static function add(
        MessageId $id,
        MessageCategory $category,
        MessageBody $body,
        MessageSeverity $severity,
        Stations $stations,
    ): Message {
        $message = new Message();

        $messageWasAdded = new MessageWasAdded(
            $id,
            $category,
            $body,
            $severity,
            $stations
        );

        $message->apply($messageWasAdded);

        return $message;
    }

    public function update(
        MessageId $id,
        MessageCategory $category,
        MessageBody $body,
        MessageSeverity $severity,
        Stations $stations,
    ): void {

        $messageWasUpdated = new MessageWasUpdated(
            $id,
            $category,
            $body,
            $severity,
            $stations,
        );

        $this->apply($messageWasUpdated);
    }

    public function remove(): void
    {
        $messageWasRemoved = new MessageWasRemoved($this->id);

        $this->apply($messageWasRemoved);
    }

    public function applyMessageWasUpdated(MessageWasUpdated $event): void
    {
        $this->category = $event->category;
        $this->body     = $event->body;
        $this->severity = $event->severity;
        $this->stations = $event->stations;
    }

    public function applyMessageWasAdded(MessageWasAdded $event): void
    {
        $this->id       = $event->id;
        $this->category = $event->category;
        $this->body     = $event->body;
        $this->severity = $event->severity;
        $this->stations = $event->stations;
    }

    public function getAggregateRootId(): string
    {
        return (string) $this->id;
    }
}
