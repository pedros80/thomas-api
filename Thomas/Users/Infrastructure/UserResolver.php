<?php

namespace Thomas\Users\Infrastructure;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Thomas\Shared\Infrastructure\Exceptions\EventStreamNotFound;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Entities\User;
use Thomas\Users\Domain\Exceptions\InvalidJWT;
use Thomas\Users\Domain\Exceptions\UserNotFound;
use Thomas\Users\Domain\UsersRepository;

final class UserResolver
{
    public function __construct(
        private UsersRepository $users,
        private string $secret,
        private string $algo
    ) {
    }

    public function resolve(?string $jwt): User
    {
        if (!$jwt) {
            throw InvalidJWT::create();
        }

        $token = JWT::decode($jwt, new Key($this->secret, $this->algo));
        $email = new Email($token->email);

        // if (isset($token->exp) && $token->exp < time()) {
        //     throw UserNotFound::fromEmail($email);
        // }

        try {
            $user = $this->users->find($email);

            return $user;
        } catch (EventStreamNotFound | UserNotFound) {
            throw UserNotFound::fromEmail($email);
        }
    }
}
