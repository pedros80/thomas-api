<?php

namespace Thomas\News\Infrastructure;

use GuzzleHttp\Client;
use SimpleXMLElement;
use Thomas\News\Domain\NewsService;

final class HttpNewsService implements NewsService
{
    public function __construct(
        private Client $client,
        private RSSParser $parser
    ) {
    }

    public function get(): array
    {
        return $this->parser->parse($this->xml());
    }

    private function xml(): SimpleXMLElement
    {
        return new SimpleXMLElement($this->client->get('')->getBody()->getContents());
    }
}
