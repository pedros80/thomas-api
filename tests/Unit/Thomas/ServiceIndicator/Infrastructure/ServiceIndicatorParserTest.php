<?php

namespace Tests\Unit\Thomas\ServiceIndicator\Infrastructure;

use PHPUnit\Framework\TestCase;
use Thomas\ServiceIndicator\Domain\ServiceIndicator;
use Thomas\ServiceIndicator\Infrastructure\ServiceIndicatorFactory;
use Thomas\ServiceIndicator\Infrastructure\ServiceIndicatorParser;

final class ServiceIndicatorParserTest extends TestCase
{
    public function testParserConvertsXMLToArrayOfDomainObjects(): void
    {
        $factory = new ServiceIndicatorFactory();
        $parser  = new ServiceIndicatorParser();

        $data = $parser->parse($factory->makeXML());

        $this->assertInstanceOf(ServiceIndicator::class, $data[0]);
    }
}
