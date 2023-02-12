<?php

namespace Thomas\RealTimeIncidents\Application\Commands;

use Stomp\Transport\Frame;
use Thomas\Shared\Application\Command;
use Thomas\Shared\Application\MessageToCommand;

final class RTICommandFactory
{
    public function __construct(
        private array $converters
    ) {
    }

    public function make(Frame $message): ?Command
    {
        $converter = $this->getConverter($message);

        if ($converter) {
            return $converter->convert($message);
        }

        return null;
    }

    private function getConverter(Frame $message): ?MessageToCommand
    {
        $type = $message->getHeaders()['INCIDENT_MESSAGE_STATUS'];

        if (array_key_exists($type, $this->converters)) {
            return $this->converters[$type];
        }

        return null;
    }
}
