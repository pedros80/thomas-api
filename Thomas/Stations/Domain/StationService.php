<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain;

interface StationService
{
    public function search(string $search): array;
}
