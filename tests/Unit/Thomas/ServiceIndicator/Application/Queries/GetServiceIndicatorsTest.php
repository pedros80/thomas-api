<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\ServiceIndicator\Application\Queries;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Thomas\ServiceIndicator\Application\Queries\GetServiceIndicators;
use Thomas\ServiceIndicator\Domain\ServiceIndicator;
use Thomas\ServiceIndicator\Domain\ServiceIndicatorOptions;
use Thomas\ServiceIndicator\Infrastructure\HttpServiceIndicatorService;
use Thomas\ServiceIndicator\Infrastructure\MockServiceIndicatorFactory;
use Thomas\ServiceIndicator\Infrastructure\ServiceIndicatorParser;
use Thomas\Shared\Domain\KBService;
use Thomas\Shared\Domain\Params\OrderBy;
use Thomas\Shared\Domain\Params\PageNumber;
use Thomas\Shared\Domain\Params\PerPage;
use Thomas\Shared\Domain\Params\Sort;

final class GetServiceIndicatorsTest extends TestCase
{
    use ProphecyTrait;

    public function testQueryReturnsArrayOfDomainObjects(): void
    {
        $factory   = new MockServiceIndicatorFactory();
        $kbService = $this->prophesize(KBService::class);
        $kbService->serviceIndicators()->willReturn($factory->makeXML());

        $query = new GetServiceIndicators(
            new HttpServiceIndicatorService(
                $kbService->reveal(),
                new ServiceIndicatorParser()
            )
        );

        $options = new ServiceIndicatorOptions(
            new PageNumber(2),
            new PerPage(1),
            Sort::ASC,
            new OrderBy('tocName')
        );

        $result = $query->page($options);

        $this->assertInstanceOf(ServiceIndicator::class, $result->toArray()[0]);
    }
}
