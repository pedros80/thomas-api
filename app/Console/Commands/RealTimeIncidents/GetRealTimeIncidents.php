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
            ['ID', 'STATUS', 'SUMMARY', 'OPERATORS'],
            $query->get()->map(fn (Incident $incident) => [
                $incident->id,
                $incident->status->value,
                $incident->body?->summary(),
                implode(', ', $incident->body?->operators()),
            ])
        );
    }
}
