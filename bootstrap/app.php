<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register API middleware
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle Authentication Error
        $exceptions->renderable(function (AuthenticationException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access. Please login.',
            ], Response::HTTP_UNAUTHORIZED);
        });

        // Handle Validation Errors
        $exceptions->renderable(function (ValidationException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $exception->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        });

        // Handle Route Not Found
        $exceptions->renderable(function (NotFoundHttpException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Route not found',
            ], Response::HTTP_NOT_FOUND);
        });

        // Handle General HTTP Exceptions
        $exceptions->renderable(function (HttpException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], $exception->getStatusCode());
        });

        // Handle Other Exceptions
        $exceptions->renderable(function (Throwable $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    })
    ->create();
