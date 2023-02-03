<?php

namespace Thomas\News\Infrastructure;

use GuzzleHttp\Client;
use SimpleXMLElement;
use Thomas\News\Domain\RSSParser;
use Thomas\News\Domain\RSSReader;

final class HttpRSSReader implements RSSReader
{
    public function __construct(
        private Client $client,
        private RSSParser $parser
    ) {
    }

    public function read(): array
    {
        return $this->parser->parse($this->xml());
    }

    private function xml(): SimpleXMLElement
    {
        return new SimpleXMLElement($this->client->get('')->getBody()->getContents());
    }
}
