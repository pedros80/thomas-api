<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain;

use Thomas\LiftsAndEscalators\Domain\AssetStatus;
use Thomas\Shared\Domain\TypedCollection;

final class AssetStatuses extends TypedCollection
{
    protected string $type = AssetStatus::class;
}
