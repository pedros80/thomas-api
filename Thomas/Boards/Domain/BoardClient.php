<?php

declare(strict_types=1);

namespace Thomas\Boards\Domain;

use stdClass;

interface BoardClient
{
    public function getArrBoardWithDetails(int $numRows, string $crs): stdClass;
    public function getDepBoardWithDetails(int $numRows, string $crs): stdClass;
}
