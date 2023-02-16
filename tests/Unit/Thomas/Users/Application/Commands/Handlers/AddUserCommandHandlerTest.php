<?php

namespace Tests\Unit\Thomas\Users\Application\Commands\Handlers;

use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Thomas\Users\Application\Commands\AddUser;
use Thomas\Users\Application\Commands\Handlers\AddUserCommandHandler;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Events\UserWasAdded;
use Thomas\Users\Domain\Exceptions\EmailAlreadyAdded;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Infrastructure\BroadwayRepository as InfrastructureBroadwayRepository;

final class AddUserCommandHandlerTest extends CommandHandlerScenarioTestCase
{
    public function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new AddUserCommandHandler(new InfrastructureBroadwayRepository($eventStore, $eventBus));
    }

    public function testExistingEmailThrowsException(): void
    {
        $this->expectException(EmailAlreadyAdded::class);
        $this->expectExceptionMessage("Email already added: 'peterwsomerville@gmail.com'.");

        $email   = new Email('peterwsomerville@gmail.com');
        $userId  = UserId::generate();
        $name    = new Name('Peter Somerville');
        $command = new AddUser($email, $name, $userId);

        $this->scenario
            ->withAggregateId($email)
            ->given([new UserWasAdded($email, $name, $userId)])
            ->when($command);
    }

    public function testNewUniqueEmailCanBeAdded(): void
    {
        $email   = new Email('peterwsomerville@gmail.com');
        $userId  = UserId::generate();
        $name    = new Name('Peter Somerville');
        $command = new AddUser($email, $name, $userId);

        $this->scenario
            ->given([])
            ->when($command)
            ->then([new UserWasAdded($email, $name, $userId)]);
    }
}
