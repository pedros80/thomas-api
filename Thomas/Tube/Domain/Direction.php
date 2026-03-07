<?php

declare(strict_types=1);

namespace Thomas\Tube\Domain;

enum Direction: string
{
    case INBOUND  = 'inbound';
    case OUTBOUND = 'outbound';
}
