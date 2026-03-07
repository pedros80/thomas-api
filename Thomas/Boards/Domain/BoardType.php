<?php

declare(strict_types=1);

namespace Thomas\Boards\Domain;

enum BoardType: string
{
    case DEPARTURES = 'Departures';
    case ARRIVALS   = 'Arrivals';
    case PLATFORM   = 'Platform';
}
