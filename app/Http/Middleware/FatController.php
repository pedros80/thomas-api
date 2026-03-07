<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Thomas\Shared\Domain\Exceptions\InvalidFatControllerRequest;

final class FatController
{
    public function handle(Request $request, Closure $next): mixed
    {
        /** @var string $secret */
        $secret    = Config::get('services.admin.secret');
        $timestamp = $request->header('X-Timestamp');
        $header    = (string) $request->header('X-Signature');

        if (!Hash::check("{$secret}{$timestamp}", $header)) {
            throw InvalidFatControllerRequest::default();
        }

        return $next($request);
    }
}
