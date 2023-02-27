<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\News\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\News\Domain\Exceptions\InvalidUrl;
use Thomas\News\Domain\Url;

final class UrlTest extends TestCase
{
    public function testInstantiates(): void
    {
        $url = new Url('https://www.bbc.co.uk/sport/av/football/64539242?at_medium=RSS&at_campaign=KARANGA');

        $this->assertInstanceOf(Url::class, $url);
        $this->assertEquals(
            'https://www.bbc.co.uk/sport/av/football/64539242?at_medium=RSS&at_campaign=KARANGA',
            (string) $url
        );
    }

    public function testInvalidUrlThrowsException(): void
    {
        $this->expectException(InvalidUrl::class);
        $this->expectExceptionMessage("'JOBBY!!!' is not a valid URL");

        new Url('JOBBY!!!');
    }
}
