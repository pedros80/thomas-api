<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Domain;

enum IncidentMessageStatus: string
{
    case NEW      = 'NEW';
    case MODIFIED = 'MODIFIED';
    case REMOVED  = 'REMOVED';
}
