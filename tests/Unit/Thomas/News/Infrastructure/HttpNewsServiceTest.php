<?php

namespace Tests\Unit\Thomas\News\Infrastructure;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Thomas\News\Domain\News;
use Thomas\News\Infrastructure\HttpNewsService;
use Thomas\News\Infrastructure\MockNewsFactory;
use Thomas\News\Infrastructure\RSSParser;

final class HttpNewsServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testServiceReturnsArrayOfDomainObjects(): void
    {
        $factory = new MockNewsFactory();
        $mock    = new MockHandler([
            new Response(200, [], $factory->makeXML()),
        ]);

        $handler = HandlerStack::create($mock);
        $client  = new Client(['handler' => $handler]);

        $service = new HttpNewsService($client, new RSSParser());

        $result = $service->get();

        $this->assertInstanceOf(News::class, $result[0]);
    }
}
