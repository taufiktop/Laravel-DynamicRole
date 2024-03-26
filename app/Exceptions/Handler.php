<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Sentry;
use Sentry\State\Scope;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

    }

    public function report(Throwable $e)
    {
        if ($this->shouldReport($e)) {
            Sentry::withScope(function (Scope $scope) use ($e) {
                $scope->setExtra('exception_message', $e->getMessage());
                $scope->setExtra('exception_code', $e->getCode());
                Sentry::captureException($e);
            });
        }

        parent::report($e); 
    }
}
