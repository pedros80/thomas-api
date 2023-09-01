<?php

declare(strict_types=1);

namespace Thomas\Users\Domain\Events;

use function Safe\json_decode;
use Thomas\Shared\Domain\Event;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\RemovedAt;
use Thomas\Users\Domain\UserId;

final class UserWasRemoved extends Event
{
    public function __construct(
        private Email $email,
        private UserId $userId,
        private RemovedAt $removedAt
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

    public function removedAt(): RemovedAt
    {
        return $this->removedAt;
    }

    public function toArray(): array
    {
        return [
            'email'     => (string) $this->email,
            'userId'    => (string) $this->userId,
            'removedAt' => (string) $this->removedAt,
        ];
    }

    public static function deserialize(string $json): static
    {
        $payload = json_decode($json);

        return new UserWasRemoved(
            new Email($payload->email),
            new UserId($payload->userId),
            RemovedAt::fromString($payload->removedAt)
        );
    }
}
