<?php

namespace App\Console\Commands\Boards;

use Illuminate\Console\Command;
use Thomas\Boards\Domain\BoardService;

final class GetBoard extends Command
{
    protected $signature   = 'board:get';
    protected $description = "I'm bored, I'm chairman of the board.";

    public function handle(BoardService $boards): void
    {
        $result = $boards->departures('DAM');

        var_dump($result);
    }
}
