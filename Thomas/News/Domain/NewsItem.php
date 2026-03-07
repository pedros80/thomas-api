<?php

declare(strict_types=1);

namespace Thomas\News\Domain;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
use Thomas\News\Domain\DatePublished;
use Thomas\News\Domain\Title;
use Thomas\News\Domain\Url;

final class NewsItem implements Arrayable, JsonSerializable
{
    public function __construct(
        public readonly Title $title,
        public readonly Url $url,
        public readonly DatePublished $datePublished
    ) {
    }

    public function toArray(): array
    {
        return [
            'title'         => $this->title,
            'url'           => $this->url,
            'datePublished' => $this->datePublished,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
