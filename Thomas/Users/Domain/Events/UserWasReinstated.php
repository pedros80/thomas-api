<?php

declare(strict_types=1);

namespace Thomas\Users\Domain\Events;

use Thomas\Shared\Domain\Event;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\UserId;

final class UserWasReinstated extends Event
{
    public function __construct(
        private Email $email,
        private UserId $existingId,
        private Name $name,
        private UserId $newId,
    ) {
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function existingId(): UserId
    {
        return $this->existingId;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function userId(): UserId
    {
        return $this->newId;
    }

    public function toArray(): array
    {
        return [
            'email'      => (string) $this->email,
            'existingId' => (string) $this->existingId,
            'name'       => (string) $this->name,
            'newId'      => (string) $this->newId,
        ];
    }

    public static function deserialize(string $json): static
    {
        $payload = json_decode($json);

        return new UserWasReinstated(
            new Email($payload->email),
            new UserId($payload->existingId),
            new Name($payload->name),
            new UserId($payload->newId)
        );
    }
}
