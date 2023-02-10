<?php

namespace Tests\Unit\Thomas\ServiceIndicator\Application\Queries;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Thomas\ServiceIndicator\Application\Queries\GetServiceIndicators;
use Thomas\ServiceIndicator\Domain\ServiceIndicator;
use Thomas\ServiceIndicator\Infrastructure\HttpServiceIndicatorService;
use Thomas\ServiceIndicator\Infrastructure\MockServiceIndicatorFactory;
use Thomas\ServiceIndicator\Infrastructure\ServiceIndicatorParser;
use Thomas\Shared\Domain\KBService;

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

        $result = $query->get();

        $this->assertInstanceOf(ServiceIndicator::class, $result[0]);
    }
}
