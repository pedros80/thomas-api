<?php

namespace Thomas\News\Domain;

interface NewsService
{
    public function get(): array;
}
