<?php

// Application: starts and configures the Laravel application.
use Illuminate\Foundation\Application;

// Exceptions: configures how application errors are handled.
use Illuminate\Foundation\Configuration\Exceptions;

// Middleware: configures request security and proxy handling.
use Illuminate\Foundation\Configuration\Middleware;

// Request: provides information about incoming website requests.
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // Trust Railway's proxy so Laravel recognizes HTTPS requests.
        $middleware->trustProxies(at: '*');

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
