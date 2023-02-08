<?php

namespace Tests\Unit\Thomas\News\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\News\Domain\DatePublished;
use Thomas\News\Domain\News;
use Thomas\News\Domain\Title;
use Thomas\News\Domain\Url;

final class NewsTest extends TestCase
{
    public function testInstantiates(): void
    {
        $news = new News(
            new Title("Match of the Day 2: Why Everton can be 'confident' about Merseyside derby"),
            new Url('https://www.bbc.co.uk/sport/av/football/64539242?at_medium=RSS&at_campaign=KARANGA'),
            DatePublished::fromString('Tue, 07 Feb 2023 12:34:17 GMT')
        );

        $this->assertInstanceOf(News::class, $news);
        $this->assertEquals([
            'title'         => "Match of the Day 2: Why Everton can be 'confident' about Merseyside derby",
            'url'           => 'https://www.bbc.co.uk/sport/av/football/64539242?at_medium=RSS&at_campaign=KARANGA',
            'datePublished' => '2023-02-07 12:34:17',
        ], $news->toArray());
        $this->assertEquals([
            'title'         => "Match of the Day 2: Why Everton can be 'confident' about Merseyside derby",
            'url'           => 'https://www.bbc.co.uk/sport/av/football/64539242?at_medium=RSS&at_campaign=KARANGA',
            'datePublished' => '2023-02-07 12:34:17',
        ], $news->jsonSerialize());
    }
}
