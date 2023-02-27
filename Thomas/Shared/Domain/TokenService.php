<?php

declare(strict_types=1);

namespace Thomas\Shared\Domain;

interface TokenService
{
    public function get(): array;
}
