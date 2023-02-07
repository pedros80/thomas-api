<?php

namespace Thomas\RealTimeIncidents\Domain;

use Stomp\Transport\Frame;

interface MessageParser
{
    public function parse(Frame $message): Incident;
}
