<?php

declare(strict_types=1);

namespace Thomas\News\Infrastructure;

use SimpleXMLElement;
use Thomas\News\Domain\DatePublished;
use Thomas\News\Domain\News;
use Thomas\News\Domain\Title;
use Thomas\News\Domain\Url;

final class RSSParser
{
    public function parse(SimpleXMLElement $xml): array
    {
        $out = [];
        foreach ($xml->channel->item as $item) {
            $out[] = new News(
                new Title((string) $item->title),
                new Url((string) $item->link),
                DatePublished::fromString((string) $item->pubDate)
            );
        }

        return $out;
    }
}
