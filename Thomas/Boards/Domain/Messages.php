<?php

declare(strict_types=1);

namespace Thomas\Boards\Domain;

use Thomas\Boards\Domain\Message;
use Thomas\Shared\Domain\TypedCollection;

final class Messages extends TypedCollection
{
    protected string $type = Message::class;
}
