<?php

declare(strict_types=1);

namespace Thomas\Shared\Application;

use Stomp\Transport\Frame;
use Thomas\Shared\Application\Command;

interface MessageToCommand
{
    public function convert(Frame $message): Command;
}
