<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Application;

use Stomp\Transport\Frame;
use Thomas\RealTimeIncidents\Application\Commands\RTICommandFactory;
use Thomas\Shared\Application\CommandBus;
use Thomas\Shared\Application\MessageRouter;

final class RTIMessageRouter implements MessageRouter
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly RTICommandFactory $commandFactory
    ) {
    }

    public function route(Frame $message): void
    {
        $command = $this->commandFactory->make($message);

        if ($command) {
            $this->commandBus->dispatch($command);
        }
    }
}
