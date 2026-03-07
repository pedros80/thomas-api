<?php

declare(strict_types=1);

namespace Thomas\Boards\Domain;

use Thomas\Boards\Domain\OperatorCode;
use Thomas\Shared\Domain\TypedCollection;

final class OperatorCodes extends TypedCollection
{
    protected string $type = OperatorCode::class;

    public function toStrings(): array
    {
        return $this->map(fn (OperatorCode $operator) => (string) $operator);
    }
}
