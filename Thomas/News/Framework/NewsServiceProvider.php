<?php

namespace Thomas\News\Framework;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Thomas\News\Application\Queries\GetNewsHeadlines;
use Thomas\News\Domain\RSSReader;
use Thomas\News\Infrastructure\BBCRSSParser;
use Thomas\News\Infrastructure\HttpRSSReader;
use Thomas\News\Infrastructure\Queries\GetNewsHeadlinesBBCRSS;

final class NewsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->bindRSS();
        $this->bindNewsQueries();
    }

    private function bindRSS(): void
    {
        $this->app->bind(
            RSSReader::class,
            fn () => new HttpRSSReader(
                new Client([
                    'headers' => [
                        'User-Agent' => 'Thomas Rss Reader',
                        'Accept'     => 'application/xml',
                    ],
                    'base_uri' => config('services.rss.bbc.url'),
                ]),
                new BBCRSSParser()
            )
        );

        $this->app->bind(
            GetNewsHeadlinesBBCRSS::class,
            fn () => new GetNewsHeadlinesBBCRSS($this->app->make(RSSReader::class))
        );
    }

    private function bindNewsQueries(): void
    {
        $this->app->bind(
            GetNewsHeadlines::class,
            fn () => $this->app->make(GetNewsHeadlinesBBCRSS::class)
        );
    }
}
