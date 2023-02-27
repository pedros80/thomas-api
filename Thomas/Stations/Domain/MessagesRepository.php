<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain;

use Thomas\Stations\Domain\Entities\Message;

interface MessagesRepository
{
    public function find(MessageID $id): Message;
    public function save(Message $message): void;
}
