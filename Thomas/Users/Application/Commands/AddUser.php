<?php

declare(strict_types=1);

namespace Thomas\Users\Application\Commands;

use Thomas\Shared\Application\Command;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\UserId;

final class AddUser extends Command
{
    public function __construct(
        public readonly Email $email,
        public readonly Name $name,
        public readonly UserId $userId,
    ) {
    }

    public function toArray(): array
    {
        return [
            'email'  => $this->email,
            'name'   => $this->name,
            'userId' => $this->userId,
        ];
    }

    public static function fromArray(array $user): AddUser
    {
        return new AddUser(
            new Email($user['email']),
            new Name($user['name']),
            new UserId($user['userId'])
        );
    }
}
