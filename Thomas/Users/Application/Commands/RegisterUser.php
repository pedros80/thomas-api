<?php

namespace Thomas\Users\Application\Commands;

use Thomas\Shared\Application\Command;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\Password;
use Thomas\Users\Domain\PasswordHash;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Domain\VerifyToken;

final class RegisterUser extends Command
{
    private PasswordHash $passwordHash;

    public function __construct(
        private Email $email,
        private Name $name,
        private Password $password,
        private UserId $userId,
        private VerifyToken $verifyToken
    ) {
        $this->passwordHash = $password->hash();
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function passwordHash(): PasswordHash
    {
        return $this->passwordHash;
    }

    public function verifyToken(): VerifyToken
    {
        return $this->verifyToken;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function toArray(): array
    {
        return [
            'email' => (string) $this->email,
            'name'  => (string) $this->name,
        ];
    }
}
