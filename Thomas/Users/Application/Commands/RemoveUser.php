<?php

namespace Thomas\Users\Application\Commands;

use Thomas\Shared\Application\Command;
use Thomas\Users\Domain\Email;

final class RemoveUser extends Command
{
    public function __construct(
        private Email $email
    ) {
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function toArray(): array
    {
        return [
            'email' => (string) $this->email,
        ];
    }
}
