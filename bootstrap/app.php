<?php

use Illuminate\Foundation\Application;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Middleware\RedirectIfSessionExpired;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'redirectIfSessionExpired' => RedirectIfSessionExpired::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response) {
            if ($response->getStatusCode() === 419) {
                toastr()->error('Halaman kedaluwarsa, silahkan coba lagi.');
                return back()->with([
                    'message' => 'Halaman kedaluwarsa, silahkan coba lagi.',
                ]);
            }

            return $response;
        });
    })->create();
