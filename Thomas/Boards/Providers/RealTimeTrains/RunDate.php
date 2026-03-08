<?php

declare(strict_types=1);

namespace Thomas\Boards\Providers\RealTimeTrains;

use Thomas\Shared\Domain\StringValue;

final class RunDate extends StringValue
{
    public static function fromString(string $date): RunDate
    {
        return new RunDate(str_replace('-', '/', $date));
    }
}
