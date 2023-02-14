<?php

namespace Tests\Unit\Thomas\Users\Application\Commands\Handlers;

use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Thomas\Users\Application\Commands\Handlers\VerifyUserCommandHandler;
use Thomas\Users\Application\Commands\VerifyUser;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Events\UserWasRegistered;
use Thomas\Users\Domain\Events\UserWasVerified;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\Password;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Domain\VerifyToken;
use Thomas\Users\Infrastructure\BroadwayRepository as InfrastructureBroadwayRepository;

final class VerifyUserCommandHandlerTest extends CommandHandlerScenarioTestCase
{
    public function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new VerifyUserCommandHandler(new InfrastructureBroadwayRepository($eventStore, $eventBus));
    }

    public function testRegisteredUserCanBeVerified(): void
    {
        $email       = new Email('peterwsomerville@gmail.com');
        $userId      = UserId::generate();
        $verifyToken = VerifyToken::fromUserId($userId);
        $password    = Password::generate();


        $command = new VerifyUser(
            $email,
            $verifyToken
        );

        $this->scenario
            ->withAggregateId($email)
            ->given([
                new UserWasRegistered(
                    $email,
                    new Name('Peter Somerville'),
                    $password->hash(),
                    $userId,
                    $verifyToken
                )
            ])
            ->when($command)
            ->then([
                new UserWasVerified(
                    $email,
                    $verifyToken,
                    $userId,
                )
            ]);
    }
}
