<?php

namespace Thomas\Users\Application\Queries;

use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\UserId;
use Thomas\Users\Domain\VerifyToken;

interface GetEmailFromUserIdAndVerifyToken
{
    public function get(UserId $userId, VerifyToken $verifyToken): Email;
}
