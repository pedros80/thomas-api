<?php

namespace Tests\Feature\Thomas\News\Application\Queries;

use Tests\TestCase;
use Thomas\News\Application\Queries\GetNewsHeadlines;
use Thomas\News\Domain\News;

final class GetNewsHeadlinesTest extends TestCase
{
    public function testGetReturnsArrayOfHeadlines(): void
    {
        $query  = resolve(GetNewsHeadlines::class);
        $result = $query->get();

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertInstanceOf(News::class, $result[0]);
    }
}
