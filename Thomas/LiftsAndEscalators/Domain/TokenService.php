<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Domain;

interface TokenService
{
    public function get(): Token;
}
