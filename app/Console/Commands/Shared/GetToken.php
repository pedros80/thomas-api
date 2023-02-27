<?php

declare(strict_types=1);

namespace App\Console\Commands\Shared;

use Illuminate\Console\Command;
use Thomas\Shared\Domain\TokenService;

final class GetToken extends Command
{
    protected $signature   = 'token:get';
    protected $description = 'Get a token';

    public function handle(TokenService $tokens): void
    {
        $token = $tokens->get();

        $this->table(['User', 'Expires', 'Token'], [$token]);
    }
}
