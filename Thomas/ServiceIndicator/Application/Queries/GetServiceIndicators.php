<?php

declare(strict_types=1);

namespace Thomas\ServiceIndicator\Application\Queries;

use Thomas\ServiceIndicator\Domain\ServiceIndicator;
use Thomas\ServiceIndicator\Domain\ServiceIndicatorOptions;
use Thomas\ServiceIndicator\Domain\ServiceIndicators;
use Thomas\ServiceIndicator\Domain\ServiceIndicatorService;
use Thomas\Shared\Domain\Params\OrderBy;
use Thomas\Shared\Domain\Params\Sort;

final class GetServiceIndicators
{
    public function __construct(
        private readonly ServiceIndicatorService $service,
    ) {
    }

    public function count(): int
    {
        return count($this->service->get());
    }

    public function page(ServiceIndicatorOptions $options): ServiceIndicators
    {
        $data = $this->sort($this->service->get()->toArray(), $options);

        return new ServiceIndicators(array_slice($data, $options->getOffset(), $options->perPage->getValue()));
    }

    private function comp(ServiceIndicator $indicator, OrderBy $property): string
    {
        return strtolower((string) $indicator->$property);
    }

    private function sort(array $data, ServiceIndicatorOptions $options): array
    {
        $property = $options->orderBy;

        if ($options->sort === Sort::ASC) {
            usort(
                $data,
                fn (ServiceIndicator $a, ServiceIndicator $b): int => $this->comp($a, $property) <=> $this->comp($b, $property)
            );
        } else {
            usort(
                $data,
                fn (ServiceIndicator $a, ServiceIndicator $b): int => $this->comp($b, $property) <=> $this->comp($a, $property)
            );
        }

        return $data;
    }
}
