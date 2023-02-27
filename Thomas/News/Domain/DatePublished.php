<?php

declare(strict_types=1);

namespace Thomas\News\Domain;

use DateTimeImmutable;

final class DatePublished
{
    private function __construct(
        private DateTimeImmutable $date
    ) {
    }

    public function format(string $format): string
    {
        return $this->date->format($format);
    }

    public function __toString()
    {
        return $this->format('Y-m-d H:i:s');
    }

    public static function fromString(string $date): DatePublished
    {
        return new DatePublished(new DateTimeImmutable($date));
    }
}
