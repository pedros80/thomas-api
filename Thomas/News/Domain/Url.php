<?php

declare(strict_types=1);

namespace Thomas\News\Domain;

use Thomas\News\Domain\Exceptions\InvalidUrl;

final class Url
{
    public function __construct(
        private string $url
    ) {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw InvalidUrl::fromString($url);
        }
    }

    public function __toString(): string
    {
        return $this->url;
    }
}
