<?php

declare(strict_types=1);

namespace Thomas\Shared\Domain\Params;

use Illuminate\Http\Request;

abstract class QueryOptions
{
    abstract public static function fromRequest(Request $request): static;
}
