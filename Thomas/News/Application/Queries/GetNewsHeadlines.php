<?php

namespace Thomas\News\Application\Queries;

interface GetNewsHeadlines
{
    public function get(int $num = 10): array;
}
