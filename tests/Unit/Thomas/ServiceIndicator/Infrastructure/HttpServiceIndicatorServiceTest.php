<?php

namespace Tests\Unit\Thomas\ServiceIndicator\Infrastructure;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Thomas\ServiceIndicator\Domain\ServiceIndicator;
use Thomas\ServiceIndicator\Infrastructure\HttpServiceIndicatorService;
use Thomas\ServiceIndicator\Infrastructure\ServiceIndicatorFactory;
use Thomas\ServiceIndicator\Infrastructure\ServiceIndicatorParser;
use Thomas\Shared\Domain\KBService;

final class HttpServiceIndicatorServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testServiceReturnsArrayOfDomainObjects(): void
    {
        $factory = new ServiceIndicatorFactory();
        $client  = $this->prophesize(KBService::class);
        $client->serviceIndicators()->willReturn($factory->makeXML());
        $service = new HttpServiceIndicatorService($client->reveal(), new ServiceIndicatorParser());

        $result = $service->get();

        $this->assertInstanceOf(ServiceIndicator::class, $result[0]);
    }
}
