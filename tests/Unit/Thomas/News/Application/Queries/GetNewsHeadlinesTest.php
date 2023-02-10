<?php

namespace Tests\Unit\Thomas\News\Application\Queries;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Thomas\News\Application\Queries\GetNewsHeadlines;
use Thomas\News\Domain\News;
use Thomas\News\Infrastructure\HttpNewsService;
use Thomas\News\Infrastructure\MockNewsFactory;
use Thomas\News\Infrastructure\RSSParser;

final class GetNewsHeadlinesTest extends TestCase
{
    public function testQueryReturnsArrayOfDomainObjects(): void
    {
        $factory = new MockNewsFactory();
        $mock    = new MockHandler([
            new Response(200, [], $factory->makeXML()),
        ]);

        $handler = HandlerStack::create($mock);
        $client  = new Client(['handler' => $handler]);

        $service = new HttpNewsService($client, new RSSParser());
        $query   = new GetNewsHeadlines($service);

        $result = $query->get();

        $this->assertInstanceOf(News::class, $result[0]);
    }
}
