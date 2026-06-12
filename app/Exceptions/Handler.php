<?php

namespace App\Exceptions;

use Throwable;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
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
        if ($request->is('api/*')) {
            if ($e instanceof ValidationException && $request->expectsJson()) {
                return ApiResponse::error(
                    message: 'Validation errors',
                    errors: $e->errors(),
                    code: Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            if ($e instanceof AuthenticationException) {
                if (request()->routeIs('login')) {
                    return ApiResponse::error(message: 'Email ou mot de passe incorrect', code: Response::HTTP_UNAUTHORIZED);
                }

                return ApiResponse::error(message: 'Session expirée ou Token manquant', code: Response::HTTP_UNAUTHORIZED);
            }

            if ($e instanceof AuthorizationException) {
                return ApiResponse::error(
                    message: 'Accès refusé',
                    code: Response::HTTP_FORBIDDEN
                );
            }

            if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
                return ApiResponse::error(
                    message: 'Ressource introuvable',
                    code: Response::HTTP_NOT_FOUND
                );
            }

            if (config('app.env') === 'production') {
                Log::error('API Error', [
                    'message' => $e->getMessage(),
                    'exception' => $e,
                    'url' => $request->fullUrl(),
                ]);

                return ApiResponse::error(
                    message: 'Erreur interne du serveur',
                    code: Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
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
