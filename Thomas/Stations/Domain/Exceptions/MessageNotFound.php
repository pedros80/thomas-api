<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain\Exceptions;

use Exception;
use Thomas\Stations\Domain\MessageId;

final class MessageNotFound extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 404);
    }

    public static function fromId(MessageId $id): MessageNotFound
    {
        return new MessageNotFound("Message '{$id}' not found.");
    }
}
