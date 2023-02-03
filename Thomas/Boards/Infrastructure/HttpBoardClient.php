<?php

namespace Thomas\Boards\Infrastructure;

use Pedros80\NREphp\Services\LiveDepartureBoard;
use stdClass;
use Thomas\Boards\Domain\BoardClient;

final class HttpBoardClient implements BoardClient
{
    public function __construct(
        private LiveDepartureBoard $ldb
    ) {
    }

    public function getDepBoardWithDetails(int $numRows, string $crs): stdClass
    {
        return $this->ldb->getDepBoardWithDetails($numRows, $crs);
    }

    public function getArrBoardWithDetails(int $numRows, string $crs): stdClass
    {
        return $this->ldb->getArrBoardWithDetails($numRows, $crs);
    }
}
