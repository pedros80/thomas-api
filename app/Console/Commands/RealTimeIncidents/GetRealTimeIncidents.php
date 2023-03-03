<?php

declare(strict_types=1);

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
            ['ID', 'STATUS', 'SUMMARY', "OPERATORS"],
            array_map(function (Incident $incident) {
                return [
                    $incident->id(),
                    $incident->status(),
                    $incident->body()?->summary(),
                    implode(', ', $incident->body()?->operators()),
                ];
            }, $query->get())
        );
    }
}
