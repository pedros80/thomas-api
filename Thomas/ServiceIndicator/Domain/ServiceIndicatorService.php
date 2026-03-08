<?php

declare(strict_types=1);

namespace Thomas\ServiceIndicator\Domain;

use Thomas\ServiceIndicator\Domain\ServiceIndicators;

interface ServiceIndicatorService
{
    public function get(): ServiceIndicators;
}
