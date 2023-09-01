<?php

declare(strict_types=1);

namespace Thomas\Shared\Domain\Exceptions;

use Exception;

final class ExternalDataConnectionFailure extends Exception
{
    private function __construct(
        string $message,
        int $code
    ) {
        parent::__construct($message, $code);
    }

    public static function fromErrorAndService(string $service, string $error, int $code=400): ExternalDataConnectionFailure
    {
        return new ExternalDataConnectionFailure("Error getting data from {$service}: {$error}", $code);
    }
}
