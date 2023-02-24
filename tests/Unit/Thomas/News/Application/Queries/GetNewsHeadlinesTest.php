<?php

namespace Tests\Unit\Thomas\News\Application\Queries;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Cache\Repository;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Thomas\News\Application\Queries\GetNewsHeadlines;
use Thomas\News\Domain\News;
use Thomas\News\Infrastructure\HttpNewsService;
use Thomas\News\Infrastructure\MockNewsFactory;
use Thomas\News\Infrastructure\RSSParser;

final class GetNewsHeadlinesTest extends TestCase
{
    use ProphecyTrait;

    public function testQueryReturnsArrayOfDomainObjects(): void
    {
        $factory = new MockNewsFactory();
        $mock    = new MockHandler([
            new Response(200, [], $factory->makeContent()),
        ]);

        $handler = HandlerStack::create($mock);
        $client  = new Client(['handler' => $handler]);
        $cache   = $this->prophesize(Repository::class);

        $service = new HttpNewsService($client, new RSSParser(), $cache->reveal());
        $query   = new GetNewsHeadlines($service);

        $result = $query->get();

        $this->assertInstanceOf(News::class, $result[0]);
    }
}
