<?php

namespace Thomas\Shared\Application;

use Stomp\Transport\Frame;

final class DarwinCommandFactory
{
    public function __construct(
        private array $parsers
    ) {
    }

    public function make(Frame $message): ?Command
    {
        $parser = $this->getConverter($message);

        if ($parser) {
            return $parser->convert($message);
        }

        return null;
    }

    private function getConverter(Frame $message): ?DarwinMessageToCommand
    {
        $type = $message->getHeaders()['MessageType'];

        if (array_key_exists($type, $this->parsers)) {
            return $this->parsers[$type];
        }

        return null;
    }
}
