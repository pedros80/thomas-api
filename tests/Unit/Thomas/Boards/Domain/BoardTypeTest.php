<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Boards\Domain;

use PHPUnit\Framework\TestCase;
use function Safe\json_encode;
use Thomas\Boards\Domain\BoardType;
use Thomas\Boards\Domain\Exceptions\InvalidBoardType;

final class BoardTypeTest extends TestCase
{
    public function testBoardTypeCanBeInstantiated(): void
    {
        $type = new BoardType(BoardType::DEPARTURES);

        $this->assertInstanceOf(BoardType::class, $type);
        $this->assertEquals('Departures', (string) $type);
        $this->assertEquals('"Departures"', json_encode($type));
    }

    public function testInvalidBoardTypeThrowsException(): void
    {
        $this->expectException(InvalidBoardType::class);
        $this->expectExceptionMessage("'jobby' is not a valid Board Type");

        new BoardType('jobby');
    }
}
