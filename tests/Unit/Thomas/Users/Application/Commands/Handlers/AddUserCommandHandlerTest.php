<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Users\Application\Commands\Handlers;

use Broadway\CommandHandling\CommandHandler;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Tests\Unit\Thomas\Users\Application\Commands\Handlers\BaseUserCommandHandler;
use Thomas\Users\Application\Commands\Handlers\AddUserCommandHandler;
use Thomas\Users\Domain\Exceptions\EmailAlreadyAdded;
use Thomas\Users\Infrastructure\BroadwayRepository;

final class AddUserCommandHandlerTest extends BaseUserCommandHandler
{
    public function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new AddUserCommandHandler(new BroadwayRepository($eventStore, $eventBus));
    }

    public function testExistingEmailThrowsException(): void
    {
        $this->expectException(EmailAlreadyAdded::class);
        $this->expectExceptionMessage("Email already added: 'peterwsomerville@gmail.com'.");

        $this->scenario
            ->withAggregateId((string) $this->email)
            ->given([
                $this->makeUserWasAdded(),
            ])->when($this->makeAddUser());
    }

    public function testNewUniqueEmailCanBeAdded(): void
    {
        $this->scenario
            ->given([])
            ->when($this->makeAddUser())
            ->then([
                $this->makeUserWasAdded(),
            ]);
    }

    public function testDeletedUserCanBeReinstated(): void
    {
        $this->scenario
            ->withAggregateId((string) $this->email)
            ->given([
                $this->makeUserWasAdded(),
                $this->makeUserWasRemoved(),
            ])
            ->when($this->makeAddUser())
            ->then([
                $this->makeUserWasReinstated(),
            ]);
    }
}
