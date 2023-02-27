<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Users\Application\Commands\Handlers;

use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Thomas\Users\Application\Commands\Handlers\RemoveUserCommandHandler;
use Thomas\Users\Application\Commands\RemoveUser;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Events\UserWasAdded;
use Thomas\Users\Domain\Events\UserWasRemoved;
use Thomas\Users\Domain\Exceptions\UserNotFound;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Infrastructure\BroadwayRepository as InfrastructureBroadwayRepository;

final class RemoveUserCommandHandlerTest extends CommandHandlerScenarioTestCase
{
    public function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new RemoveUserCommandHandler(new InfrastructureBroadwayRepository($eventStore, $eventBus));
    }

    public function testRemovingUnknownUserThrowsException(): void
    {
        $this->expectException(UserNotFound::class);
        $this->expectExceptionMessage("User Not Found: 'peterwsomerville@gmail.com'");

        $email   = new Email('peterwsomerville@gmail.com');
        $command = new RemoveUser($email);

        $this->scenario
            ->given([])
            ->when($command);
    }

    public function testExistingUserCanBeRemoved(): void
    {
        $email   = new Email('peterwsomerville@gmail.com');
        $userId  = UserId::generate();
        $name    = new Name('Peter Somerville');
        $command = new RemoveUser($email);

        $this->scenario
            ->withAggregateId((string) $email)
            ->given([new UserWasAdded($email, $name, $userId)])
            ->when($command)
            ->then([new UserWasRemoved($email, $userId)]);
    }
}
