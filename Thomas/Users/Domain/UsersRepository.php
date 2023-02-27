<?php

declare(strict_types=1);

namespace Thomas\Users\Domain;

use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Entities\User;

interface UsersRepository
{
    public function find(Email $email): User;
    public function save(User $user): void;
}
