<?php

declare(strict_types=1);

namespace App\Console\Commands\Users;

use Firebase\JWT\JWT;
use Illuminate\Console\Command;

final class GenerateJWT extends Command
{
    protected $signature   = 'users:jwt';
    protected $description = 'Generate a jwt';

    public function handle(): void
    {
        $email = 'peterwsomerville@gmail.com';

        $token = JWT::encode([
            'email' => $email,
            'test'  => rand(),
            // 'exp'   => strtotime('+7 days'),
        ], config('jwt.secret'), config('jwt.algo'));

        $this->info($token);
    }
}
