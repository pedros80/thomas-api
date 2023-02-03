<?php

namespace Thomas\News\Infrastructure;

use SimpleXMLElement;
use Thomas\News\Domain\RSSParser;

final class BBCRSSParser implements RSSParser
{
    public function parse(SimpleXMLElement $xml): array
    {
        $out = [];
        foreach ($xml->channel->item as $item) {
            $out[] = [
                'title' => (string) $item->title,
                'url'   => (string) $item->link,
                'date'  => (string) $item->pubDate,
            ];
        }

        return $out;
    }
}
