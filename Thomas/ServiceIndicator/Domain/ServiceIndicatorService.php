<?php

declare(strict_types=1);

namespace Thomas\ServiceIndicator\Domain;

interface ServiceIndicatorService
{
    public function get(): array;
}
