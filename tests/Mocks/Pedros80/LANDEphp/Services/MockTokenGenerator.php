<?php

namespace Tests\Mocks\Thomas\LiftsAndEscalators\Infrastructure;

use Pedros80\LANDEphp\Contracts\Tokens;
use Symfony\Component\Uid\Ulid;

final class MockTokenGenerator implements Tokens
{
    public function getToken(): array
    {
        return [
            'user'    => Ulid::generate(),
            'expires' => date('Y-m-d H:i:s', (int) strtotime("+ 300 seconds")),
            'token'   => 'token',
        ];
    }
}
