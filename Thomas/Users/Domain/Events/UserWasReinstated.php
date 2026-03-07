<?php

declare(strict_types=1);

namespace Thomas\Users\Domain\Events;

use stdClass;
use Thomas\Shared\Domain\Event;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\UserId;

use function Safe\json_decode;

final class UserWasReinstated extends Event
{
    public function __construct(
        public readonly Email $email,
        public readonly UserId $existingId,
        public readonly Name $name,
        public readonly UserId $newId,
    ) {
    }

    public function toArray(): array
    {
        return [
            'email'      => $this->email,
            'existingId' => $this->existingId,
            'name'       => $this->name,
            'newId'      => $this->newId,
        ];
    }

    public static function deserialize(string $json): static
    {
        /** @var stdClass $payload */
        $payload = json_decode($json);

        return new UserWasReinstated(
            new Email($payload->email),
            new UserId($payload->existingId),
            new Name($payload->name),
            new UserId($payload->newId)
        );
    }
}
