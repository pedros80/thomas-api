<?php

namespace App\Console\Commands\RealTimeIncidents;

use Illuminate\Console\Command;
use Thomas\RealTimeIncidents\Application\Queries\GetIncidents;
use Thomas\RealTimeIncidents\Domain\Incident;

final class GetRealTimeIncidents extends Command
{
    protected $signature   = 'rti:get';
    protected $description = 'Get all current rti';

    public function handle(GetIncidents $query): void
    {
        $this->table(
            ['ID', 'STATUS', 'SUMMARY'],
            array_map(function (Incident $incident) {
                return [
                    $incident->id(),
                    $incident->status(),
                    $incident->body()->summary(),
                ];
            }, $query->get())
        );
    }
}
