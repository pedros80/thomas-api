<?php

declare(strict_types=1);

namespace App\Console\Commands\Tube;

use Illuminate\Console\Command;
use Thomas\Shared\Domain\NaptanId;
use Thomas\Tube\Application\Queries\GetNaptansByLine;
use Thomas\Tube\Domain\TubeLineId;
use Thomas\Tube\Domain\TubeService;

final class Test extends Command
{
    protected $signature   = 'tubeBoards:test';
    protected $description = 'balh';

    public function handle(
        GetNaptansByLine $getNaptans,
    ): void {

        // var_dump($lines->get());


        $naptans = $getNaptans->get(TubeLineId::fromString('jubilee'));

        $naptan = new NaptanId(array_keys($naptans)[0]);

        var_dump($naptans);

        // var_dump($arrivals->get($naptan));

        // $data = $tubes->getArrivalsByNaptan(new NaptanId('940GZZLUASL'));

        // var_dump($data);

        // $lines = $tubes->getTubeLines();

        // var_dump($lines);

        // $stops = $tubes->getNaptansByLine(TubeLineId::fromString('bakerloo'));

        // foreach ($stops as $stop) {
        //     var_dump($stop['naptanId']);
        //     var_dump($stop['commonName']);
        // }

        // var_dump($stops);
    }
}
