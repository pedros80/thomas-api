<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\News\Domain;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Cache\Repository;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Thomas\News\Domain\NewsItem;
use Thomas\News\Domain\NewsItemsOptions;
use Thomas\News\Domain\NewsService;
use Thomas\News\Domain\RSSParser;
use Thomas\News\Infrastructure\MockNewsFactory;
use Thomas\Shared\Domain\Params\OrderBy;
use Thomas\Shared\Domain\Params\PageNumber;
use Thomas\Shared\Domain\Params\PerPage;
use Thomas\Shared\Domain\Params\Sort;

final class NewsServiceTest extends TestCase
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

        $service = new NewsService($client->reveal(), $parser, $cache->reveal());

        $result = $service->page(
            new NewsItemsOptions(
                new PageNumber(2),
                new PerPage(1),
                Sort::ASC,
                new OrderBy('publishedDate')
            )
        );

        $this->assertInstanceOf(NewsItem::class, $result->toArray()[0]);
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

        $service = new NewsService($client, new RSSParser(), $cache->reveal());

        $result = $service->page(
            new NewsItemsOptions(
                new PageNumber(2),
                new PerPage(1),
                Sort::ASC,
                new OrderBy('publishedDate')
            )
        );

        $this->assertInstanceOf(NewsItem::class, $result->toArray()[0]);
    }
}
