<?php

declare(strict_types=1);

namespace Thomas\Shared\Domain\Params;

use Thomas\Shared\Domain\Exceptions\InvalidPerPage;

final class PerPage
{
    public function __construct(
        private readonly int $page
    ) {
        if ($page < 1) {
            throw InvalidPerPage::fromNumber($page);
        }
    }

    public function getValue(): int
    {
        return $this->page;
    }
}
