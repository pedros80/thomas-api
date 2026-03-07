<?php

declare(strict_types=1);

namespace Thomas\Boards\Domain;

use Thomas\Shared\Domain\TypedCollection;

final class Services extends TypedCollection
{
    protected string $type = Service::class;
}
