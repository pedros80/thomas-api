<?php

namespace Tests\Unit\Thomas\Stations\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Domain\Exceptions\InvalidMessageCategory;
use Thomas\Stations\Domain\MessageCategory;

final class MessageCategoryTest extends TestCase
{
    public function testInstantiates(): void
    {
        $category = new MessageCategory(MessageCategory::STATION);

        $this->assertInstanceOf(MessageCategory::class, $category);
        $this->assertEquals('Station', (string) $category);
    }

    public function testInvalidCategoryThrowsException(): void
    {
        $this->expectException(InvalidMessageCategory::class);
        $this->expectExceptionMessage("'jobby' is not a valid message category.");

        new MessageCategory('jobby');
    }
}
