<?php

declare(strict_types=1);

namespace App\Console\Commands\News;

use Illuminate\Console\Command;
use Thomas\News\Domain\NewsItem;
use Thomas\News\Domain\NewsItems;
use Thomas\News\Domain\NewsItemsOptions;
use Thomas\News\Domain\NewsService;
use Thomas\Shared\Domain\Params\OrderBy;
use Thomas\Shared\Domain\Params\PageNumber;
use Thomas\Shared\Domain\Params\PerPage;
use Thomas\Shared\Domain\Params\Sort;

final class GetNews extends Command
{
    protected $signature   = 'news:get {--perPage=10} {--page=1} {--sort=ASC} {--orderBy=publishedDate}';
    protected $description = 'You like Huey Lewis and the News?';

    public function handle(NewsService $news): void
    {
        $options = $this->getNewsItemsOptions();
        $this->displayNews($news->page($options));
    }

    private function displayNews(NewsItems $news): void
    {
        $this->table(
            ['Title', 'URL',  'Date'],
            $news->map(fn (NewsItem $item) => $item->toArray())
        );
    }

    private function getNewsItemsOptions(): NewsItemsOptions
    {
        return new NewsItemsOptions(
            new PageNumber((int) $this->option('page')),
            new PerPage((int) $this->option('perPage')),
            Sort::from((string) $this->option('sort')),
            new OrderBy((string) $this->option('orderBy')),
        );
    }
}
