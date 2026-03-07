<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain;

enum MessageSeverity: int
{
    case NORMAL = 0;
    case MINOR  = 1;
    case MAJOR  = 2;
    case SEVERE = 3;

    public function label(): string
    {
        return match($this) {
            self::NORMAL => 'normal',
            self::MINOR  => 'minor',
            self::MAJOR  => 'major',
            self::SEVERE => 'severe',
        };

    }
}
