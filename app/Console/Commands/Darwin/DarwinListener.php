<?php

declare(strict_types=1);

namespace App\Console\Commands\Darwin;

use Exception;
use Illuminate\Console\Command;
use Pedros80\NREphp\Services\Broker;
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

    private int $backOff  = 1;
    private int $numFails = 0;
    private const WAIT    = 10000;

    private Broker $broker;

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

    public function handle(PushPortBroker $broker): void
    {
        $this->broker = $broker;

        while ($this->run) {
            try {
                $this->listen();
            } catch (Exception $e) {
                if (++$this->numFails > 10) {
                    $this->error("Too many Exceptions: disconnecting...");
                    $this->shutdown();

                    return;
                }

                if (
                    get_class($e) === HeartbeatException::class &&
                    str_contains($e->getMessage(), 'Could not send heartbeat')
                ) {
                    $wait = 60 * 5; // wait 5 minutes
                } else {
                    $this->backOff *= 2;
                    $wait = $this->backOff;
                }

                $this->error("{$e->getMessage()}: waiting for {$wait} secconds");
                sleep($wait);
            }
        }
    }
}
