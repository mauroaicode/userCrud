<?php

namespace App\Exceptions;

use Illuminate\Http\{
    JsonResponse,
    RedirectResponse
};
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;


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

    /**
     * Handles unauthenticated authentication exceptions.
     *
     * @param mixed $request The HTTP request.
     * @return Response|JsonResponse|RedirectResponse The response to the request.
     */
    protected function unauthenticated($request, AuthenticationException $exception): Response|JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json([
                'isSuccessful' => false,
                'message' => __('auth.session_not_active')
            ], Response::HTTP_UNAUTHORIZED);
        }

        return redirect()->guest(route('login')); // @codeCoverageIgnore
    }
}
