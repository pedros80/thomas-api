<?php

declare(strict_types=1);

namespace Thomas\News\Domain;

use GuzzleHttp\Client;
use Illuminate\Contracts\Cache\Repository;
use SimpleXMLElement;
use Thomas\News\Domain\NewsItems;
use Thomas\Shared\Domain\Params\Sort;

final class NewsService
{
    private const CACHE_KEY = 'news.xml';
    private const TTL       = 5 * 60;

    public function __construct(
        private readonly Client $client,
        private readonly RSSParser $parser,
        private readonly Repository $cache,
    ) {
    }

    private function sort(array $data, NewsItemsOptions $options): array
    {
        if ($options->sort === Sort::ASC) {
            usort(
                $data,
                fn (NewsItem $a, NewsItem $b): int => $a->datePublished->format('U') <=> $b->datePublished->format('U')
            );
        } else {
            usort(
                $data,
                fn (NewsItem $a, NewsItem $b): int => $b->datePublished->format('U') <=> $a->datePublished->format('U')
            );
        }

        return $data;
    }

    public function page(NewsItemsOptions $options): NewsItems
    {
        $data = $this->sort($this->all()->toArray(), $options);

        return new NewsItems(array_slice($data, $options->getOffset(), $options->perPage->getValue()));
    }

    public function count(): int
    {
        return count($this->all());
    }

    public function all(): NewsItems
    {
        /** @var NewsItems $news */
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
