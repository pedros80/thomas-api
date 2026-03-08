<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Thomas\Shared\Domain\Exceptions\InvalidCRS;
use Thomas\Shared\Domain\Exceptions\InvalidFatControllerRequest;
use Thomas\Shared\Domain\Exceptions\InvalidOrderBy;
use Thomas\Shared\Domain\Exceptions\InvalidPageNumber;
use Thomas\Shared\Domain\Exceptions\InvalidPerPage;
use Thomas\Shared\Domain\Exceptions\InvalidSort;
use Thomas\Shared\Framework\ErrorResponse;
use Thomas\Users\Domain\Exceptions\UserNotFound;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        InvalidCRS::class,
        InvalidFatControllerRequest::class,
        InvalidOrderBy::class,
        InvalidPageNumber::class,
        InvalidPerPage::class,
        InvalidSort::class,
        UserNotFound::class,
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e): ErrorResponse
    {
        return ErrorResponse::fromException($e);
    }
}
