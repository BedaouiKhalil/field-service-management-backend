<?php

namespace App\Exceptions;

use Throwable;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function render($request, Throwable $e)
    {

        if ($e instanceof ValidationException) {
            if ($request->expectsJson()) {
                return ApiResponse::sendResponse(
                    422,
                    'Validation Errors',
                    $e->errors()
                );
            }
        }

        if ($e instanceof AuthenticationException) {
            return ApiResponse::sendResponse(401, 'Unauthenticated');
        }

        if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
            return ApiResponse::sendResponse(404, 'Resource not found');
        }

        if ($e instanceof AuthorizationException) {
            return ApiResponse::sendResponse(403, 'Access denied');
        }

        if (config('app.env') === 'production') {
            Log::error('API Error: ' . $e->getMessage(), [
                'exception' => $e,
                'url' => $request->fullUrl(),
            ]);
            return ApiResponse::sendResponse(500, 'Internal server error');
        }

        return parent::render($request, $e);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
