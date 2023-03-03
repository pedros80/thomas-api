<?php

declare(strict_types=1);

namespace App\Console\Commands\RealTimeIncidents;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Pedros80\NREphp\Services\RealTimeIncidentsBroker;
use Stomp\Network\Observer\Exception\HeartbeatException;
use Stomp\Transport\Frame;
use Symfony\Component\Console\Command\SignalableCommandInterface;
use Thomas\RealTimeIncidents\Application\RTIMessageRouter;

final class RealTimeIncidentListener extends Command implements SignalableCommandInterface
{
    protected $signature   = 'rti:listen';
    protected $description = 'wait, listen... can you smell that?';

    private bool $run = true;

    private int $tries = 1;
    private const WAIT = 10000;

    private RealTimeIncidentsBroker $broker;

    public function __construct(
        private RTIMessageRouter $router
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

    private function listen(): void
    {
        while ($this->run) {
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
        }
    }

    public function handle(RealTimeIncidentsBroker $broker): void
    {
        $this->broker = $broker;

        while ($this->run) {
            try {
                $this->listen();
            } catch (HeartbeatException) {
                if ($this->tries / 2 >= 6) {
                    $this->info("<error>Too many HeartBeatExceptions: disconnecting...");
                    $this->shutdown();

                    return;
                }
                $this->tries *= 2;
                $wait = $this->tries * 60;
                $this->info(date('Y-m-d H:i:s'));
                $this->info("<error>HeartBeatException: waiting for {$wait}ms</error>");
                $this->info(date('Y-m-d H:i:s'));
                sleep($wait);
            }
        }
    }
}
