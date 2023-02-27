<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\RealTimeIncidents\Application;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Thomas\RealTimeIncidents\Application\Commands\Converters\ModifiedMessageToCommand;
use Thomas\RealTimeIncidents\Application\Commands\Converters\NewMessageToCommand;
use Thomas\RealTimeIncidents\Application\Commands\Converters\RemovedMessageToCommand;
use Thomas\RealTimeIncidents\Application\Commands\RTICommandFactory;
use Thomas\RealTimeIncidents\Application\RTIMessageRouter;
use Thomas\RealTimeIncidents\Domain\IncidentMessageStatus;
use Thomas\RealTimeIncidents\Infrastructure\MockRTIMessageFactory;
use Thomas\Shared\Application\CommandBus;

final class RTIMessageRouterTest extends TestCase
{
    use ProphecyTrait;

    public function provideMessageMethods(): array
    {
        return [
            [IncidentMessageStatus::NEW],
            [IncidentMessageStatus::MODIFIED],
            [IncidentMessageStatus::REMOVED]
        ];
    }

    /**
     * @dataProvider provideMessageMethods
     */
    public function testNewMessageDispatchesCommand(string $method): void
    {
        $factory = new RTICommandFactory([
            IncidentMessageStatus::NEW      => new NewMessageToCommand(),
            IncidentMessageStatus::MODIFIED => new ModifiedMessageToCommand(),
            IncidentMessageStatus::REMOVED  => new RemovedMessageToCommand(),
        ]);
        $commandBus = $this->prophesize(CommandBus::class);

        $message = MockRTIMessageFactory::$method();
        $command = $factory->make($message);

        $commandBus->dispatch($command)->shouldBeCalled();

        $router = new RTIMessageRouter(
            $commandBus->reveal(),
            $factory
        );

        $router->route($message);
    }
}
