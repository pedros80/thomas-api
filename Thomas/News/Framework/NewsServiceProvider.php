<?php

declare(strict_types=1);

namespace Thomas\News\Framework;

use GuzzleHttp\Client;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Thomas\News\Domain\NewsService;
use Thomas\News\Domain\RSSParser;

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
            fn (): NewsService => new NewsService(
                new Client([
                    'headers' => [
                        'User-Agent' => 'Thomas Rss Reader',
                        'Accept'     => 'application/xml',
                    ],
                    'base_uri' => Config::get('services.rss.bbc.url'),
                ]),
                new RSSParser(),
                $this->app->make(Repository::class),
            )
        );
    }
}
