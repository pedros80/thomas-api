<?php

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
        ], config('jwt.key'), 'HS256');

        $this->info($token);
    }
}
