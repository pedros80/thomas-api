<?php

namespace Thomas\News\Domain;

interface RSSReader
{
    public function read(): array;
}
