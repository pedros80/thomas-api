<?php

declare(strict_types=1);

namespace Thomas\Shared\Domain;

use DateTimeImmutable;

abstract class Date
{
    final private function __construct(
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

    public static function fromString(string $date): static
    {
        return new static(new DateTimeImmutable($date));
    }

    public static function now(): static
    {
        return new static(new DateTimeImmutable(date('Y-m-d H:i:s')));
    }
}
