<?php

declare(strict_types=1);

namespace Thomas\Shared\Application;

use Stomp\Transport\Frame;
use Thomas\Shared\Application\CommandBus;
use Thomas\Shared\Application\DarwinCommandFactory;

final class DarwinMessageRouter implements MessageRouter
{
    public function __construct(
        private CommandBus $commandBus,
        private DarwinCommandFactory $commandFactory,
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
