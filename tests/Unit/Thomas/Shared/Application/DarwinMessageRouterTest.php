<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Shared\Application;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Thomas\Shared\Application\CommandBus;
use Thomas\Shared\Application\DarwinCommandFactory;
use Thomas\Shared\Application\DarwinMessageRouter;
use Thomas\Shared\Infrastructure\MockDarwinMessageFactory;
use Thomas\Stations\Application\Commands\StationMessageToCommand;

final class DarwinMessageRouterTest extends TestCase
{
    use ProphecyTrait;

    public function testStationMessageFrameDispatchesCommand(): void
    {
        $commandFactory = new DarwinCommandFactory([
            'OW' => new StationMessageToCommand()
        ]);

        $message = MockDarwinMessageFactory::stationMessage();
        $command = $commandFactory->make($message);

        $commandBus = $this->prophesize(CommandBus::class);
        $commandBus->dispatch($command)->shouldBeCalled();
        $router = new DarwinMessageRouter(
            $commandBus->reveal(),
            new DarwinCommandFactory([
                'OW' => new StationMessageToCommand()
            ])
        );

        $router->route($message);
    }
}
