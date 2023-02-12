<?php

namespace App\Console\Commands\RealTimeIncidents;

use Illuminate\Console\Command;
use Pedros80\NREphp\Services\RealTimeIncidentsBroker;
use Stomp\Transport\Frame;
use Thomas\RealTimeIncidents\Application\RTIMessageRouter;

final class RealTimeIncidentListener extends Command
{
    protected $signature   = 'rti:listen';
    protected $description = 'wait, listen... can you smell that?';

    public function handle(RealTimeIncidentsBroker $broker, RTIMessageRouter $router): void
    {
        while (true) {
            $message = $broker->read();
            if ($message instanceof Frame) {
                if ($message['type'] === 'terminate') {
                    $this->info('<comment>Received shutdown command</comment>');

                    return;
                }
                $router->route($message);
                $broker->ack($message);
            }
            usleep(100000);
        }
    }
}
