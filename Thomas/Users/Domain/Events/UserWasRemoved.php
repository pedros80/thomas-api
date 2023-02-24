<?php

namespace Thomas\Users\Domain\Events;

use Thomas\Shared\Domain\Event;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\UserId;

final class UserWasRemoved extends Event
{
    public function __construct(
        private Email $email,
        private UserId $userId
    ) {
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function toArray(): array
    {
        return [
            'email'  => (string) $this->email,
            'userId' => (string) $this->userId,
        ];
    }

    public static function deserialize(string $json): static
    {
        $payload = json_decode($json);

        return new UserWasRemoved(
            new Email($payload->email),
            new UserId($payload->userId)
        );
    }
}
