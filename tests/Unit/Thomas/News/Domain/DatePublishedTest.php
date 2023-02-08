<?php

namespace Tests\Unit\Thomas\News\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\News\Domain\DatePublished;

final class DatePublishedTest extends TestCase
{
    public function testInstantiates(): void
    {
        $date = DatePublished::fromString('Tue, 07 Feb 2023 18:30:44 GMT');

        $this->assertInstanceOf(DatePublished::class, $date);
        $this->assertEquals('2023-02-07 18:30:44', (string) $date);
    }
}
