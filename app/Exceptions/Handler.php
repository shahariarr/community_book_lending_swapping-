<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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
        // $this->reportable(function (Throwable $e) {
        //     //
        // });

        // $this->renderable(function (NotFoundHttpException $e) {
        //     return response()->view('errors.404', [], 404);
        // });

        // // Fix: Use the appropriate exception type for 500 errors
        // $this->renderable(function (HttpException $e) {
        //     if ($e->getStatusCode() === 500) {
        //         return response()->view('errors.500', [], 500);
        //     }
        // });

        // // Fix: Use AuthenticationException for 401 errors
        // $this->renderable(function (Throwable $e) {
        //     return response()->view('errors.401', [], 401);
        // });

        // // Fix: Use AccessDeniedHttpException for 403 errors
        // $this->renderable(function (AccessDeniedHttpException $e) {
        //     return response()->view('errors.403', [], 403);
        // });

        // // Alternative for 403: Use HttpException with status code check
        // $this->renderable(function (HttpException $e) {
        //     if ($e->getStatusCode() === 403) {
        //         return response()->view('errors.403', [], 403);
        //     }
        // });
    }
}
