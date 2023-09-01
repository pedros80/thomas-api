<?php

declare(strict_types=1);

namespace Thomas\Shared\Application;

use Stomp\Transport\Frame;

interface MessageRouter
{
    public function route(Frame $message): void;
}
