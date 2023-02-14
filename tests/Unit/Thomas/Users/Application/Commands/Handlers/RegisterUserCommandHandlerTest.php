<?php

namespace Tests\Unit\Thomas\Users\Application\Commands\Handlers;

use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Thomas\Users\Application\Commands\Handlers\RegisterUserCommandHandler;
use Thomas\Users\Application\Commands\RegisterUser;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Events\UserWasRegistered;
use Thomas\Users\Domain\Exceptions\EmailAlreadyRegistered;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\Password;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Domain\VerifyToken;
use Thomas\Users\Infrastructure\BroadwayRepository as InfrastructureBroadwayRepository;

final class RegisterUserCommandHandlerTest extends CommandHandlerScenarioTestCase
{
    public function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new RegisterUserCommandHandler(new InfrastructureBroadwayRepository($eventStore, $eventBus));
    }

    public function testExistingEmailThrowsException(): void
    {
        $this->expectException(EmailAlreadyRegistered::class);
        $this->expectExceptionMessage("Email already registered: 'peterwsomerville@gmail.com'.");

        $email       = new Email('peterwsomerville@gmail.com');
        $userId      = UserId::generate();
        $verifyToken = VerifyToken::fromUserId($userId);

        $command = new RegisterUser(
            $email,
            new Name('Peter Somerville'),
            Password::generate(),
            $userId,
            $verifyToken
        );

        $this->scenario
            ->withAggregateId($email)
            ->given([
                new UserWasRegistered(
                    $email,
                    new Name('Peter Somerville'),
                    $command->passwordHash(),
                    $userId,
                    $verifyToken
                )
            ])
            ->when($command);
    }

    public function testNewUniqueEmailCanRegister(): void
    {
        $email       = new Email('peterwsomerville@gmail.com');
        $userId      = UserId::generate();
        $verifyToken = VerifyToken::fromUserId($userId);

        $command = new RegisterUser(
            $email,
            new Name('Peter Somerville'),
            Password::generate(),
            $userId,
            $verifyToken
        );

        $this->scenario
            ->given([])
            ->when($command)
            ->then([
                new UserWasRegistered(
                    $email,
                    new Name('Peter Somerville'),
                    $command->passwordHash(),
                    $userId,
                    $verifyToken
                )
            ]);
    }
}
