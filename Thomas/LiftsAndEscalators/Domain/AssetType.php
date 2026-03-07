<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain;

enum AssetType: string
{
    case LIFT      = 'Lift';
    case ESCALATOR = 'Escalator';
}
