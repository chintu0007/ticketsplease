<?php

namespace App\Http\Exceptions;

use App\Errors\APIError;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class APIExceptions
{
    public static function handleAll(Exceptions $exceptions): void
    {
        APIExceptions::handleAuthenticationException($exceptions);
        APIExceptions::handleModelNotFoundException($exceptions);
        APIExceptions::handleNotFoundHttpException($exceptions);
        APIExceptions::handleMethodNotAllowedHttpException($exceptions);
    }

    private static function handleAuthenticationException(Exceptions $exceptions): void
    {
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 401,
                    'data' => null,
                    'error' => [
                        'type' => APIError::Unauthorized,
                        'message' => 'This is a protected route, you need to provide a valid token before continuing.',
                    ],
                ], 401);
            }
        });
    }

    private static function handleModelNotFoundException(Exceptions $exceptions): void
    {
        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            if ($request->is('api/*')) {
                return APIExceptions::handleNotFoundException();
            }
        });
    }

    private static function handleNotFoundHttpException(Exceptions $exceptions): void
    {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return APIExceptions::handleNotFoundException();
            }
        });
    }

    private static function handleMethodNotAllowedHttpException(Exceptions $exceptions): void
    {
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 400,
                    'data' => null,
                    'error' => [
                        'type' => APIError::WrongArguments,
                        'message' => 'This method is not allowed for this route. Please verify the method before performing the request.',
                    ],
                ], 400);
            }
        });
    }

    private static function handleNotFoundException(): JsonResponse
    {
        return response()->json([
            'status' => 404,
            'data' => null,
            'error' => [
                'type' => APIError::NotFound,
                'message' => 'Resource not found',
            ],
        ], 404);
    }
}
