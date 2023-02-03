<?php

namespace Thomas\Stations\Domain;

interface StationService
{
    public function search(string $search): array;
}
