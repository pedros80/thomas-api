<?php

declare(strict_types=1);

namespace Thomas\Shared\Framework;

use Throwable;

final class ErrorResponse extends Response
{
    public function __construct(int $statusCode, Error ...$errors)
    {
        parent::__construct($this->formatData(...$errors), $statusCode);
    }

    private function formatData(Error ...$errors): array
    {
        return [
            'success' => false,
            'errors'  => $this->aggregateErrors(...$errors),
        ];
    }

    public static function fromException(Throwable $exception): ErrorResponse
    {
        return new ErrorResponse(
            $exception->getCode() ?: 400,
            Error::fromException($exception)
        );
    }

    public static function default(): ErrorResponse
    {
        return new ErrorResponse(
            500,
            new Error(500, 'Unknown Error', 'An unknown error has occurred')
        );
    }

    public static function badRequest(string $message): ErrorResponse
    {
        return new ErrorResponse(
            400,
            new Error(400, 'Bad Request', $message)
        );
    }

    private function aggregateErrors(Error ...$errors): array
    {
        $return = [];

        foreach ($errors as $error) {
            $return[] = $error->toArray();
        }

        return $return;
    }
}
