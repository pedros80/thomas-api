<?php

declare(strict_types=1);

namespace Thomas\Users\Domain\Events;

use stdClass;
use Thomas\Shared\Domain\Event;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\UserId;

use function Safe\json_decode;

final class UserWasAdded extends Event
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

    public static function deserialize(string $json): static
    {
        /** @var stdClass $payload */
        $payload = json_decode($json);

        return new UserWasAdded(
            new Email($payload->email),
            new Name($payload->name),
            new UserId($payload->userId)
        );
    }
}
