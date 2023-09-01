<?php

declare(strict_types=1);

namespace Tests\Mocks\Pedros80\LANDEphp\Services;

use function Safe\date;
use function Safe\strtotime;
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
