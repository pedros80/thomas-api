<?php

namespace Thomas\Users\Infrastructure;

use Broadway\Domain\AggregateRoot;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Broadway\Repository\AggregateNotFoundException;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Entities\User;
use Thomas\Users\Domain\Exceptions\UserNotFound;
use Thomas\Users\Domain\UsersRepository;

class BroadwayRepository extends EventSourcingRepository implements UsersRepository
{
    public function __construct(EventStore $eventStore, EventBus $eventBus)
    {
        parent::__construct(
            $eventStore,
            $eventBus,
            User::class,
            new PublicConstructorAggregateFactory()
        );
    }

    public function find(Email $id): User
    {
        try {
            /** @var User $user */
            $user = parent::load((string) $id);

            return $user;
        } catch (AggregateNotFoundException) {
            throw UserNotFound::fromEmail($id);
        }
    }

    public function save(AggregateRoot $aggregate): void
    {
        parent::save($aggregate);
    }
}
