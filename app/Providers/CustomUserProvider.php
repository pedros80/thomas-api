<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Thomas\Users\Domain\UsersRepository;

final class CustomUserProvider implements UserProvider
{
    public function __construct(
        private UsersRepository $repo
    ) {
    }

    public function retrieveById($email)
    {
        return $this->repo->find($email);
    }

    public function retrieveByToken($identifier, $token)
    {
        //
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        //
    }

    public function retrieveByCredentials(array $credentials)
    {
        //
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return true;
    }
}
