<?php

namespace Thomas\Users\Application\Commands;

use Thomas\Shared\Application\Command;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\UserId;

final class AddUser extends Command
{
    public function __construct(
        private Email $email,
        private Name $name,
        private UserId $userId,
    ) {
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function toArray(): array
    {
        return [
            'email'  => (string) $this->email,
            'name'   => (string) $this->name,
            'userId' => (string) $this->userId,
        ];
    }
}
