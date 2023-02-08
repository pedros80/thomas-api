<?php

namespace App\Console\Commands\ServiceIndicator;

use Illuminate\Console\Command;
use Thomas\ServiceIndicator\Application\Queries\GetServiceIndicators;
use Thomas\ServiceIndicator\Domain\ServiceIndicator;

final class GetServiceIndicator extends Command
{
    protected $signature   = 'serviceIndicator:get';
    protected $description = 'Get service indicators and parse';

    public function handle(GetServiceIndicators $query): void
    {
        $data = $query->get();

        $this->table(
            ['Code', 'Name', 'Status', 'Image'],
            array_map(fn (ServiceIndicator $service) => $service->toArray(), $data)
        );
    }
}
