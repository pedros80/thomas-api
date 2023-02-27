<?php

declare(strict_types=1);

namespace Thomas\Shared\Infrastructure;

use Pedros80\NREphp\Services\TokenGenerator;
use Thomas\Shared\Domain\TokenService;

final class HttpTokenService implements TokenService
{
    public function __construct(
        private TokenGenerator $tokens
    ) {
    }

    public function get(): array
    {
        return $this->tokens->get();
    }
}
