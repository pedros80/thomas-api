<?php

namespace Thomas\ServiceIndicator\Application\Queries;

use Thomas\ServiceIndicator\Domain\ServiceIndicatorService;

final class GetServiceIndicators
{
    public function __construct(
        private ServiceIndicatorService $service
    ) {
    }

    public function get(): array
    {
        return $this->service->get();
    }
}
