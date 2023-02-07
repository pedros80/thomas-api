<?php

namespace App\Console\Commands\RealTimeIncidents;

use Illuminate\Console\Command;
use Pedros80\NREphp\Services\RealTimeIncidentsBroker;
use Stomp\Transport\Frame;
use Thomas\RealTimeIncidents\Application\Commands\CommandFactory;
use Thomas\RealTimeIncidents\Domain\MessageParser;
use Thomas\Shared\Application\CommandBus;

final class RealTimeIncidentListener extends Command
{
    protected $signature   = 'rti:listen';
    protected $description = 'wait, listen... can you smell that?';

    public function __construct(
        private MessageParser $messageParser,
        private CommandBus $commandBus,
        private CommandFactory $commandFactory
    ) {
        parent::__construct();
    }

    public function handle(RealTimeIncidentsBroker $broker): void
    {
        while (true) {
            $message = $broker->read();
            if ($message instanceof Frame) {
                if ($message['type'] === 'terminate') {
                    $this->info('<comment>Received shutdown command</comment>');

                    return;
                }
                $this->handleMessage($message);
                $broker->ack($message);
            }
            usleep(100000);
        }
    }

    private function handleMessage(Frame $message): void
    {
        $incident = $this->messageParser->parse($message);
        $this->commandBus->dispatch($this->commandFactory->fromIncident($incident));
        $this->info('<info>Processed message: ' . (string) $message . '</info>');
    }
}
