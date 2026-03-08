<?php

declare(strict_types=1);

namespace Thomas\News\Domain;

use SimpleXMLElement;
use Thomas\News\Domain\DatePublished;
use Thomas\News\Domain\NewsItem;
use Thomas\News\Domain\NewsItems;
use Thomas\News\Domain\Title;
use Thomas\News\Domain\Url;

final class RSSParser
{
    public function parse(SimpleXMLElement $xml): NewsItems
    {
        $out = [];

        foreach ($xml->channel->item as $item) {
            $out[] = new NewsItem(
                new Title((string) $item->title),
                new Url((string) $item->link),
                DatePublished::fromString((string) $item->pubDate),
            );
        }

        return new NewsItems($out);
    }
}
