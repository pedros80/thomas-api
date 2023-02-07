<?php

namespace App\Console\Commands\RealTimeIncidents;

use Illuminate\Console\Command;
use Thomas\RealTimeIncidents\Application\Queries\GetIncidents;

final class GetRealTimeIncidents extends Command
{
    protected $signature   = 'rti:get';
    protected $description = 'Get all current rti';

    public function handle(GetIncidents $query): void
    {
        var_dump($query->get());
    }
}
