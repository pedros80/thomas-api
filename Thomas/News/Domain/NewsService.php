<?php

declare(strict_types=1);

namespace Thomas\News\Domain;

interface NewsService
{
    public function get(): array;
}
