<?php

namespace Thomas\Stations\Domain;

final class MessageBody
{
    public function __construct(
        private string $body
    ) {
    }

    public function __toString(): string
    {
        return $this->body;
    }
}
