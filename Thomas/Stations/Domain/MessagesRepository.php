<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain;

use Thomas\Stations\Domain\Entities\Message;
use Thomas\Stations\Domain\MessageId;

interface MessagesRepository
{
    public function find(MessageId $id): Message;
    public function save(Message $message): void;
}
