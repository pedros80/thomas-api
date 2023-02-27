<?php

declare(strict_types=1);

namespace Thomas\News\Infrastructure;

use GuzzleHttp\Client;
use Illuminate\Contracts\Cache\Repository;
use SimpleXMLElement;
use Thomas\News\Domain\NewsService;

final class HttpNewsService implements NewsService
{
    private const CACHE_KEY = 'news.xml';
    private const TTL       = 5 * 60;

    public function __construct(
        private Client $client,
        private RSSParser $parser,
        private Repository $cache
    ) {
    }

    public function get(): array
    {
        $news = $this->cache->get(self::CACHE_KEY);

        if (!$news) {
            $news = $this->parser->parse($this->xml());
            $this->cache->put(self::CACHE_KEY, $news, self::TTL);
        }

        return $news;
    }

    private function xml(): SimpleXMLElement
    {
        // @todo - catch client exceptions; try again or something?
        return new SimpleXMLElement($this->client->get('')->getBody()->getContents());
    }
}
