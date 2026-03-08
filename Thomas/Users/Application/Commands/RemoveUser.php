<?php

declare(strict_types=1);

namespace Thomas\Users\Application\Commands;

use Thomas\Shared\Application\Command;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\RemovedAt;

final class RemoveUser extends Command
{
    public function __construct(
        public readonly Email $email,
        public readonly RemovedAt $removedAt,
    ) {
    }

    public function toArray(): array
    {
        return [
            'email'     => $this->email,
            'removedAt' => $this->removedAt,
        ];
    }
}
