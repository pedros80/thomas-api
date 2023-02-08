<?php

namespace App\Console\Commands\News;

use Illuminate\Console\Command;
use Thomas\News\Application\Queries\GetNewsHeadlines;
use Thomas\News\Domain\News;

final class GetNews extends Command
{
    protected $signature   = 'news:get';
    protected $description = 'You like Huey Lewis and the News?';

    public function handle(GetNewsHeadlines $query): void
    {
        $this->displayNews($query->get());
    }

    private function displayNews(array $news): void
    {
        $this->table(
            ['Title', 'URL',  'Date'],
            array_map(fn (News $item) => $item->toArray(), $news)
        );
    }
}
