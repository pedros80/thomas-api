<?php

declare(strict_types=1);

namespace Thomas\Users\Application\Commands;

use Thomas\Shared\Application\Command;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\RemovedAt;

final class RemoveUser extends Command
{
    public function __construct(
        private Email $email,
        private RemovedAt $removedAt
    ) {
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function removedAt(): RemovedAt
    {
        return $this->removedAt;
    }

    public function toArray(): array
    {
        return [
            'email'     => (string) $this->email,
            'removedAt' => (string) $this->removedAt,
        ];
    }
}
