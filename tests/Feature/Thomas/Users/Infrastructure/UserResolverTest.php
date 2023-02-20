<?php

namespace Tests\Feature\Thomas\Users\Infrastructure;

use Tests\TestCase;
use Thomas\Users\Domain\Exceptions\InvalidJWT;
use Thomas\Users\Domain\Exceptions\UserNotFound;
use Thomas\Users\Infrastructure\UserResolver;

final class UserResolverTest extends TestCase
{
    private string $userNotFoundJWT = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InBldGVyd3NvbWVydmlsbGUrNDA0QGdtYWlsLmNvbSIsInRlc3QiOjEzMDkxNzg5MDR9.KREsamvO88gwHG4ggV1ishym0De34PVbePlz76_Q4Uc';

    public function testMissingJWTThrowsException(): void
    {
        $this->expectException(InvalidJWT::class);
        $this->expectExceptionMessage('JWT is missing or invalid; please try again.');

        /** @var UserResolver $resolver */
        $resolver = app(UserResolver::class);
        $resolver->resolve(null);
    }

    public function testJWTForUnknownUserThrowsException(): void
    {
        $this->expectException(UserNotFound::class);
        $this->expectExceptionMessage('User Not Found: peterwsomerville+404@gmail.com');

        /** @var UserResolver $resolver */
        $resolver = app(UserResolver::class);
        $resolver->resolve($this->userNotFoundJWT);
    }
}
