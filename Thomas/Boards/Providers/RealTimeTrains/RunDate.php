<?php

namespace Thomas\Boards\Providers\RealTimeTrains;

final class RunDate
{
    private function __construct(
        private string $date
    ) {
    }

    public function __toString(): string
    {
        return $this->date;
    }

    public static function fromString(string $date): RunDate
    {
        return new RunDate(str_replace('-', '/', $date));
    }
}
