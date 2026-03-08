<?php

declare(strict_types=1);

namespace App\Console\Commands\ServiceIndicator;

use Illuminate\Console\Command;
use Thomas\ServiceIndicator\Application\Queries\GetServiceIndicators;
use Thomas\ServiceIndicator\Domain\ServiceIndicator;
use Thomas\ServiceIndicator\Domain\ServiceIndicatorOptions;
use Thomas\Shared\Domain\Params\OrderBy;
use Thomas\Shared\Domain\Params\PageNumber;
use Thomas\Shared\Domain\Params\PerPage;
use Thomas\Shared\Domain\Params\Sort;

final class GetServiceIndicator extends Command
{
    protected $signature   = 'serviceIndicator:get {--perPage=10} {--page=1} {--sort=ASC} {--orderBy=tocName}';
    protected $description = 'Get service indicators and parse';

    public function handle(GetServiceIndicators $query): void
    {
        $page = $query->page($this->getServiceIndicatorOptions());

        $this->table(
            ['Code', 'Name', 'Status', 'Image'],
            $page->map(fn (ServiceIndicator $service) => $service->toArray())
        );
    }

    private function getServiceIndicatorOptions(): ServiceIndicatorOptions
    {
        return new ServiceIndicatorOptions(
            new PageNumber((int) $this->option('page')),
            new PerPage((int) $this->option('perPage')),
            Sort::from((string) $this->option('sort')),
            new OrderBy((string) $this->option('orderBy')),
        );
    }
}
