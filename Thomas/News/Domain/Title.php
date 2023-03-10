<?php

declare(strict_types=1);

namespace Thomas\News\Domain;

final class Title
{
    public function __construct(
        private string $title
    ) {
    }

    public function __toString()
    {
        return $this->title;
    }
}
