<?php

declare(strict_types=1);

namespace Thomas\Users\Domain\Exceptions;

use Exception;
use Thomas\Users\Domain\Email;

final class UserNotFound extends Exception
{
    private function __construct(string $error)
    {
        parent::__construct($error, 404);
    }

    public static function fromEmail(Email $email): UserNotFound
    {
        return new UserNotFound("User Not Found: {$email}");
    }
}
