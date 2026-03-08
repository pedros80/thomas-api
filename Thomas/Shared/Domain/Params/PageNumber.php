<?php

declare(strict_types=1);

namespace Thomas\Shared\Domain\Params;

use Thomas\Shared\Domain\Exceptions\InvalidPageNumber;

final class PageNumber
{
    public function __construct(
        private readonly int $page
    ) {
        if ($page < 1) {
            throw InvalidPageNumber::fromNumber($page);
        }
    }

    public function getValue(): int
    {
        return $this->page;
    }
}
