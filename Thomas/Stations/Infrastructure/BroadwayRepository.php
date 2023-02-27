<?php

declare(strict_types=1);

namespace Thomas\Stations\Infrastructure;

use Broadway\Domain\AggregateRoot;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Broadway\Repository\AggregateNotFoundException;
use Thomas\Shared\Infrastructure\Exceptions\EventStreamNotFound;
use Thomas\Stations\Domain\Entities\Message;
use Thomas\Stations\Domain\Exceptions\MessageNotFound;
use Thomas\Stations\Domain\MessageID;
use Thomas\Stations\Domain\MessagesRepository;

class BroadwayRepository extends EventSourcingRepository implements MessagesRepository
{
    public function __construct(EventStore $eventStore, EventBus $eventBus)
    {
        parent::__construct(
            $eventStore,
            $eventBus,
            Message::class,
            new PublicConstructorAggregateFactory()
        );
    }

    public function find(MessageID $id): Message
    {
        try {
            /** @var Message $message */
            $message = parent::load((string) $id);

            return $message;
        } catch (AggregateNotFoundException | EventStreamNotFound) {
            throw MessageNotFound::fromId($id);
        }
    }

    public function save(AggregateRoot $aggregate): void
    {
        parent::save($aggregate);
    }
}
