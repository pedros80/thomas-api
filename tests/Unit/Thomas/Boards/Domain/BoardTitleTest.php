<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Boards\Domain;

use function Safe\json_encode;
use PHPUnit\Framework\TestCase;
use Thomas\Boards\Domain\BoardTitle;

final class BoardTitleTest extends TestCase
{
    public function testBoardTitleInstantiates(): void
    {
        $title = new BoardTitle('Dalmeny');

        $this->assertInstanceOf(BoardTitle::class, $title);
        $this->assertEquals('Dalmeny', (string) $title);
        $this->assertEquals('"Dalmeny"', json_encode($title));
    }
}
