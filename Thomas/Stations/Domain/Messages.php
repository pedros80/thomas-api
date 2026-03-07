<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain;

use Thomas\Shared\Domain\TypedCollection;
use Thomas\Stations\Domain\Message;

final class Messages extends TypedCollection
{
    protected string $type = Message::class;
}
