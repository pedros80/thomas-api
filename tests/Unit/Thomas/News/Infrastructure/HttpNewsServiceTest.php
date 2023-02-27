<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\News\Infrastructure;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Cache\Repository;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Thomas\News\Domain\News;
use Thomas\News\Infrastructure\HttpNewsService;
use Thomas\News\Infrastructure\MockNewsFactory;
use Thomas\News\Infrastructure\RSSParser;

final class HttpNewsServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testServiceReturnsArrayOfDomainObjectsIfInCache(): void
    {
        $factory = new MockNewsFactory();
        $client  = $this->prophesize(Client::class);
        $parser  = new RSSParser();

        $cache = $this->prophesize(Repository::class);
        $data  = $parser->parse($factory->makeXML());
        $cache->get('news.xml')->willReturn($data);

        $service = new HttpNewsService($client->reveal(), $parser, $cache->reveal());

        $result = $service->get();

        $this->assertInstanceOf(News::class, $result[0]);
    }

    public function testServiceReturnsArrayOfDomainObjectsIfNothingInCache(): void
    {
        $factory = new MockNewsFactory();
        $mock    = new MockHandler([
            new Response(200, [], $factory->makeContent()),
        ]);

        $handler = HandlerStack::create($mock);
        $client  = new Client(['handler' => $handler]);
        $cache   = $this->prophesize(Repository::class);

        $service = new HttpNewsService($client, new RSSParser(), $cache->reveal());

        $result = $service->get();

        $this->assertInstanceOf(News::class, $result[0]);
    }
}
