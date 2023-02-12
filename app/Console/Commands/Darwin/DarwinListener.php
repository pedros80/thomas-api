<?php

namespace App\Console\Commands\Darwin;

use Illuminate\Console\Command;
use Pedros80\NREphp\Services\PushPortBroker;
use Stomp\Transport\Frame;
use Thomas\Shared\Application\DarwinMessageRouter;

final class DarwinListener extends Command
{
    protected $signature   = 'darwin:listen';
    protected $description = 'Stop, Look, Listen!!';

    public function handle(PushPortBroker $broker, DarwinMessageRouter $messageRouter): void
    {
        while (true) {
            $message = $broker->read();
            if ($message instanceof Frame) {
                if ($message['type'] === 'terminate') {
                    $this->info('<comment>Received shutdown command</comment>');

                    return;
                }

                $messageRouter->route($message);
                $broker->ack($message);
            }
            usleep(100000);
        }
    }
}
