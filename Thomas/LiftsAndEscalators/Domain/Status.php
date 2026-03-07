<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain;

enum Status: string
{
    case AVAILABLE     = 'Available';
    case UNKNOWN       = 'Unknown';
    case NOT_AVAILABLE = 'Not Available';
}
