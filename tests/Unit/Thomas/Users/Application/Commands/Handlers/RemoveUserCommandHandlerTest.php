<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Users\Application\Commands\Handlers;

use Broadway\CommandHandling\CommandHandler;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Thomas\Users\Application\Commands\Handlers\RemoveUserCommandHandler;
use Thomas\Users\Domain\Exceptions\UserNotFound;
use Thomas\Users\Infrastructure\BroadwayRepository;

final class RemoveUserCommandHandlerTest extends BaseUserCommandHandler
{
    public function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new RemoveUserCommandHandler(new BroadwayRepository($eventStore, $eventBus));
    }

    public function testRemovingUnknownUserThrowsException(): void
    {
        $this->expectException(UserNotFound::class);
        $this->expectExceptionMessage("User Not Found: 'peterwsomerville@gmail.com'");

        $this->scenario
            ->given([])
            ->when($this->makeRemoveUser());
    }

    public function testExistingUserCanBeRemoved(): void
    {
        $this->scenario
            ->withAggregateId((string) $this->email)
            ->given([
                $this->makeUserWasAdded(),
            ])->when($this->makeRemoveUser())
            ->then([
                $this->makeUserWasRemoved(),
            ]);
    }
}
