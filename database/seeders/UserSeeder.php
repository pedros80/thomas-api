<?php

namespace Database\Seeders;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Broadway\CommandHandling\SimpleCommandBus;
use Broadway\EventHandling\SimpleEventBus;
use Illuminate\Database\Seeder;
use Thomas\Shared\Infrastructure\DynamoDbEventStore;
use Thomas\Users\Application\Commands\AddUser;
use Thomas\Users\Application\Commands\Handlers\AddUserCommandHandler;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Infrastructure\BroadwayRepository;
use Thomas\Users\Infrastructure\Projections\UserWasAddedProjection;

final class UserSeeder extends Seeder
{
    private SimpleEventBus $eventBus;
    private SimpleCommandBus $commandBus;
    private DynamoDbClient $db;
    private Marshaler $marshaler;

    public function __construct()
    {
        $this->eventBus   = new SimpleEventBus();
        $this->commandBus = new SimpleCommandBus();
        $this->db         = app(DynamoDbClient::class);
        $this->marshaler  = new Marshaler();

        $projector = new UserWasAddedProjection(
            $this->db,
            $this->marshaler,
            'TestThomas'
        );

        $this->eventBus->subscribe($projector);

        $commandHandler = new AddUserCommandHandler(
            new BroadwayRepository(
                new DynamoDbEventStore(
                    $this->db,
                    $this->marshaler,
                    'TestEventStore'
                ),
                $this->eventBus
            )
        );

        $this->commandBus->subscribe($commandHandler);
    }

    public function run(): void
    {
        $command = new AddUser(
            new Email('peterwsomerville@gmail.com'),
            new Name('Peter Somerville'),
            UserId::generate(),
        );

        $this->commandBus->dispatch($command);
    }
}
