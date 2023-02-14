<?php

namespace Thomas\Users\Domain\Events;

use Thomas\Shared\Domain\Event;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Name;
use Thomas\Users\Domain\PasswordHash;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Domain\VerifyToken;

final class UserWasRegistered extends Event
{
    public function __construct(
        private Email $email,
        private Name $name,
        private PasswordHash $passwordHash,
        private UserId $userId,
        private VerifyToken $verifyToken
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

    public function passwordHash(): PasswordHash
    {
        return $this->passwordHash;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function verifyToken(): VerifyToken
    {
        return $this->verifyToken;
    }

    public function toArray(): array
    {
        return [
            'email'        => (string) $this->email,
            'name'         => (string) $this->name,
            'passwordHash' => (string) $this->passwordHash,
            'userId'       => (string) $this->userId,
            'verifyToken'  => (string) $this->verifyToken,
        ];
    }

    public static function deserialize(string $json): static
    {
        $payload = json_decode($json);

        return new UserWasRegistered(
            new Email($payload->email),
            new Name($payload->name),
            new PasswordHash($payload->passwordHash),
            new UserId($payload->userId),
            new VerifyToken($payload->verifyToken)
        );
    }
}
