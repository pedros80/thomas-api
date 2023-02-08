<?php

namespace Thomas\News\Application\Queries;

use Thomas\News\Domain\NewsService;

final class GetNewsHeadlines
{
    public function __construct(
        private NewsService $service
    ) {
    }

    public function get(): array
    {
        return $this->service->get();
    }
}
