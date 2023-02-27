<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\News\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\News\Domain\Title;

final class TitleTest extends TestCase
{
    public function testInstantiates(): void
    {
        $title = new Title("Match of the Day 2: Why Everton can be 'confident' about Merseyside derby");

        $this->assertInstanceOf(Title::class, $title);
        $this->assertEquals(
            "Match of the Day 2: Why Everton can be 'confident' about Merseyside derby",
            (string) $title
        );
    }
}
