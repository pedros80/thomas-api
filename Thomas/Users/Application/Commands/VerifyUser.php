<?php

namespace Thomas\Users\Application\Commands;

use Thomas\Shared\Application\Command;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\VerifyToken;

final class VerifyUser extends Command
{
    public function __construct(
        private Email $email,
        private VerifyToken $verifyToken
    ) {
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function verifyToken(): VerifyToken
    {
        return $this->verifyToken;
    }

    public function toArray(): array
    {
        return [
            'email'       => (string) $this->email,
            'verifyToken' => (string) $this->verifyToken,
        ];
    }
}
