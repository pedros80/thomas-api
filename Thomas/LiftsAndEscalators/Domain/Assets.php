<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain;

use Thomas\LiftsAndEscalators\Domain\Asset;
use Thomas\Shared\Domain\TypedCollection;

final class Assets extends TypedCollection
{
    protected string $type = Asset::class;

    public function lifts(): Assets
    {
        return new Assets($this->filter(fn (Asset $asset) => $asset->isLift()));
    }

    public function escalators(): Assets
    {
        return new Assets($this->filter(fn (Asset $asset) => $asset->isEscalator()));
    }
}
