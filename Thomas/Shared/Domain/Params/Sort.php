<?php

declare(strict_types=1);

namespace Thomas\Shared\Domain\Params;

enum Sort: string
{
    case ASC  = 'ASC';
    case DESC = 'DESC';
}
