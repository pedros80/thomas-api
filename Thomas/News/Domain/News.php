<?php

declare(strict_types=1);

namespace Thomas\News\Domain;

use JsonSerializable;
use Thomas\News\Domain\DatePublished;
use Thomas\News\Domain\Title;
use Thomas\News\Domain\Url;

final class News implements JsonSerializable
{
    public function __construct(
        private Title $title,
        private Url $url,
        private DatePublished $datePublished
    ) {
    }

    public function toArray(): array
    {
        return [
            'title'         => (string) $this->title,
            'url'           => (string) $this->url,
            'datePublished' => (string) $this->datePublished,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
