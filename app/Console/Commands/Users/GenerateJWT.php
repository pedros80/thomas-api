<?php

declare(strict_types=1);

namespace App\Console\Commands\Users;

use Firebase\JWT\JWT;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

final class GenerateJWT extends Command
{
    protected $signature   = 'users:jwt';
    protected $description = 'Generate a jwt';

    public function handle(): void
    {
        $email = 'peterwsomerville@gmail.com';

        /** @var string $secret */
        $secret = Config::get('jwt.secret');
        /** @var string $algo */
        $algo = Config::get('jwt.algo');

        $token = JWT::encode([
            'email' => $email,
            'test'  => rand(),
            // 'exp'   => strtotime('+7 days'),
        ], $secret, $algo);

        $this->info($token);
    }
}
