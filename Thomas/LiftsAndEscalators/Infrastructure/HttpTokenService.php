<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Infrastructure;

use Pedros80\LANDEphp\Contracts\Tokens;
use Thomas\LiftsAndEscalators\Domain\Token;
use Thomas\LiftsAndEscalators\Domain\TokenService;

final class HttpTokenService implements TokenService
{
    public function __construct(
        private Tokens $tokenGenerator
    ) {
    }

    public function get(): Token
    {
        $token = $this->tokenGenerator->getToken();

        return new Token($token['token']);
    }
}
