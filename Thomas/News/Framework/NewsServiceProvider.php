<?php

declare(strict_types=1);

namespace Thomas\News\Framework;

use GuzzleHttp\Client;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\ServiceProvider;
use Thomas\News\Application\Queries\GetNewsHeadlines;
use Thomas\News\Domain\NewsService;
use Thomas\News\Infrastructure\HttpNewsService;
use Thomas\News\Infrastructure\RSSParser;

final class NewsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->bindService();
    }

    private function bindService(): void
    {
        $this->app->bind(
            NewsService::class,
            fn () => new HttpNewsService(
                new Client([
                    'headers' => [
                        'User-Agent' => 'Thomas Rss Reader',
                        'Accept'     => 'application/xml',
                    ],
                    'base_uri' => config('services.rss.bbc.url'),
                ]),
                new RSSParser(),
                $this->app->make(Repository::class)
            )
        );

        $this->app->bind(
            GetNewsHeadlines::class,
            fn () => new GetNewsHeadlines($this->app->make(NewsService::class))
        );
    }
}
