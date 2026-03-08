<?php

declare(strict_types=1);

namespace Thomas\Tube\Domain;

use Thomas\Shared\Domain\TypedCollection;
use Thomas\Tube\Domain\TubeLineId;

final class TubeLineIds extends TypedCollection
{
    protected string $type = TubeLineId::class;
}
