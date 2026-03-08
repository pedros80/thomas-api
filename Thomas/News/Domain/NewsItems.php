<?php

declare(strict_types=1);

namespace Thomas\News\Domain;

use Thomas\Shared\Domain\TypedCollection;

final class NewsItems extends TypedCollection
{
    protected string $type = NewsItem::class;
}
