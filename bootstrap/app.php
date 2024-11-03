<?php

use App\Http\Middleware\AddressExistMiddleware;
use App\Http\Middleware\CustomerExistMiddleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->validateCsrfTokens(except: [
            '*'
        ]);

        $middleware->appendToGroup('customerMiddleware', [
            CustomerExistMiddleware::class
        ]);

        $middleware->appendToGroup('addressMiddleware', [
            AddressExistMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // laravel 11 exception handler are in here
        // Render exception
        $exceptions->render(function(NotFoundHttpException $th){
            return response()->json([
                'URL not found'
            ], 404);
        });

        $exceptions->render(function(Throwable $th){
            if($th instanceof ModelNotFoundException) {
                return response()->json([
                    'Resource not found'
                ], 404);
            }

            if($th instanceof ValidationException) {
                $errors = $th->getMessage();

                return response()->json([
                    'status' => 400,
                    'message' => $errors
                ], 400);
            }
        });

    })->create();
