<?php

declare(strict_types=1);

namespace Thomas\Shared\Application;

use Thomas\Shared\Application\Command;
use Thomas\Shared\Application\CommandHandler;

interface CommandBus
{
    public function dispatch(Command $command): void;
    public function subscribe(CommandHandler $commandHandler): void;
}
