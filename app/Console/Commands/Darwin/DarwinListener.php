<?php

namespace App\Console\Commands\Darwin;

use Illuminate\Console\Command;
use Pedros80\NREphp\Services\PushPortBroker;
use Stomp\Network\Observer\Exception\HeartbeatException;
use Stomp\Transport\Frame;
use Symfony\Component\Console\Command\SignalableCommandInterface;
use Thomas\Shared\Application\DarwinMessageRouter;

final class DarwinListener extends Command implements SignalableCommandInterface
{
    protected $signature   = 'darwin:listen';
    protected $description = 'Stop, Look, Listen!!';

    private bool $run = true;

    private int $tries = 1;
    private const WAIT = 100000;

    private PushPortBroker $broker;

    public function __construct(
        private DarwinMessageRouter $router
    ) {
        parent::__construct();
    }

    public function getSubscribedSignals(): array
    {
        return [SIGINT, SIGTERM];
    }

    public function handleSignal(int $signal): void
    {
        switch ($signal) {
            case SIGINT:
            case SIGTERM:
                $this->shutdown();

                break;
        }
    }

    private function shutdown(): void
    {
        $this->broker->disconnect();
        $this->info('Disconnected...');
        $this->run = false;
    }

    public function handle(PushPortBroker $broker): void
    {
        $this->broker = $broker;

        while ($this->run) {
            try {
                $message = $this->broker->read();
                if ($message instanceof Frame) {
                    if ($message['type'] === 'terminate') {
                        $this->info('<comment>Received shutdown command</comment>');

                        return;
                    }

                    $this->router->route($message);
                    $this->broker->ack($message);
                }
                usleep(self::WAIT);
            } catch (HeartbeatException) {
                if ($this->tries / 2 >= 6) {
                    $this->info("<error>Too many HeartBeatExceptions: disconnecting...");
                    $this->shutdown();

                    return;
                }
                $wait = $this->tries * self::WAIT;
                $this->info("<error>HeartBeatException: waiting for {$wait}ms</error>");
                usleep($wait);
                $this->tries *= 2;
            }
        }
    }
}
