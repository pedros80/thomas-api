<?php

namespace Thomas\Shared\Application;

use Stomp\Transport\Frame;

interface DarwinMessageToCommand
{
    public function convert(Frame $message): Command;
}
