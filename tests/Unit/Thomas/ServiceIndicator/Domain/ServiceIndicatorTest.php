<?php

namespace Tests\Unit\Thomas\ServiceIndicator\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\ServiceIndicator\Domain\Icon;
use Thomas\ServiceIndicator\Domain\ServiceIndicator;
use Thomas\ServiceIndicator\Domain\Status;
use Thomas\ServiceIndicator\Domain\TocCode;
use Thomas\ServiceIndicator\Domain\TocName;

final class ServiceIndicatorTest extends TestCase
{
    public function testInstantiates(): void
    {
        $serviceIndicator = new ServiceIndicator(
            new TocCode('VI'),
            new TocName('Avanti West Coast'),
            new Status('Good service'),
            new Icon('icon-tick2.png')
        );

        $this->assertInstanceOf(ServiceIndicator::class, $serviceIndicator);
        $this->assertEquals([
            'tocCode' => 'VI',
            'tocName' => 'Avanti West Coast',
            'status'  => 'Good service',
            'icon'    => 'icon-tick2.png',
        ], $serviceIndicator->toArray());
        $this->assertEquals([
            'tocCode' => 'VI',
            'tocName' => 'Avanti West Coast',
            'status'  => 'Good service',
            'icon'    => 'icon-tick2.png',
        ], $serviceIndicator->jsonSerialize());
    }
}
