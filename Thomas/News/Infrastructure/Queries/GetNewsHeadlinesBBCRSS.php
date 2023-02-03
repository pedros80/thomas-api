<?php

namespace Thomas\News\Infrastructure\Queries;

use Thomas\News\Application\Queries\GetNewsHeadlines;
use Thomas\News\Domain\RSSReader;

final class GetNewsHeadlinesBBCRSS implements GetNewsHeadlines
{
    public function __construct(
        private RSSReader $reader
    ) {
    }

    public function get(int $num = 10): array
    {
        return $this->reader->read();
    }
}
