<?php

namespace App\Console\Commands\News;

use Illuminate\Console\Command;
use Thomas\News\Application\Queries\GetNewsHeadlines;

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
            ['Title', 'Date'],
            array_map(fn (array $item) => [trim($item['title']), $item['date']], $news)
        );
    }
}
