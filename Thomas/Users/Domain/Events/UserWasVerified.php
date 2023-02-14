<?php

namespace Thomas\Users\Domain\Events;

use Thomas\Shared\Domain\Event;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Domain\VerifyToken;

final class UserWasVerified extends Event
{
    public function __construct(
        private Email $email,
        private VerifyToken $verifyToken,
        private UserId $userId
    ) {
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function verifyToken(): VerifyToken
    {
        return $this->verifyToken;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function toArray(): array
    {
        return [
            'email'       => (string) $this->email,
            'verifyToken' => (string) $this->verifyToken,
            'userId'      => (string) $this->userId,
        ];
    }

    public static function deserialize(string $json): static
    {
        $payload = json_decode($json);

        return new UserWasVerified(
            new Email($payload->email),
            new VerifyToken($payload->verifyToken),
            new UserId($payload->userId)
        );
    }
}
