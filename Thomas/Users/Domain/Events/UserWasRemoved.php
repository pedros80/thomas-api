<?php

declare(strict_types=1);

namespace Thomas\Users\Domain\Events;

use stdClass;
use Thomas\Shared\Domain\Event;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\RemovedAt;
use Thomas\Users\Domain\UserId;

use function Safe\json_decode;

final class UserWasRemoved extends Event
{
    public function __construct(
        public readonly Email $email,
        public readonly UserId $userId,
        public readonly RemovedAt $removedAt,
    ) {
    }

    public function toArray(): array
    {
        return [
            'email'     => $this->email,
            'userId'    => $this->userId,
            'removedAt' => $this->removedAt,
        ];
    }

    public static function deserialize(string $json): static
    {
        /** @var stdClass $payload */
        $payload = json_decode($json);

        return new UserWasRemoved(
            new Email($payload->email),
            new UserId($payload->userId),
            RemovedAt::fromString($payload->removedAt)
        );
    }
}
