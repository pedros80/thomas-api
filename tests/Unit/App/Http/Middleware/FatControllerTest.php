<?php

namespace Tests\Unit\App\Http\Middleware;

use App\Http\Middleware\FatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Thomas\Shared\Domain\Exceptions\InvalidFatControllerRequest;

final class FatControllerTest extends TestCase
{
    public function testMiddlewareAllowsSignedRequests(): void
    {
        $middleware = new FatController();

        $time      = time();
        $secret    = config('services.admin.secret');
        $signature = Hash::make("{$secret}{$time}");

        $request = Request::create('/', 'POST');
        $request->headers->set('X-Timestamp', (string) $time);
        $request->headers->set('X-Signature', $signature);

        $middleware->handle($request, fn () => $this->assertTrue(true));
    }

    public function testMiddlewareRejectsUnsignedRequests(): void
    {
        $this->expectException(InvalidFatControllerRequest::class);
        $this->expectExceptionMessage('You have caused confusion and delay.');

        $middleware = new FatController();

        $time      = time();
        $secret    = 'wrong secret';
        $signature = Hash::make("{$secret}{$time}");

        $request = Request::create('/', 'POST');
        $request->headers->set('X-Timestamp', (string) $time);
        $request->headers->set('X-Signature', $signature);

        $middleware->handle($request, fn () => $this->assertFalse(true));
    }
}
