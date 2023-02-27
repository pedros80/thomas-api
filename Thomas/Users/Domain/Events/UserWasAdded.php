<?php

declare(strict_types=1);

namespace Thomas\Users\Domain\Events;

use Thomas\Shared\Domain\Event;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\UserId;

final class UserWasAdded extends Event
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

    public static function deserialize(string $json): static
    {
        $payload = json_decode($json);

        return new UserWasAdded(
            new Email($payload->email),
            new Name($payload->name),
            new UserId($payload->userId)
        );
    }
}
