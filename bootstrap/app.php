<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\NoCacheMiddleware;
use App\Http\Middleware\PimpinanMiddleware;
use App\Http\Middleware\PembimbingMiddleware;
use App\Http\Middleware\UserNormalMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminOrPembimbingMiddleware;
use App\Http\Middleware\KetuaTimMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'usernormal' => UserNormalMiddleware::class,
            'admin' => AdminMiddleware::class,
            'pembimbing' => PembimbingMiddleware::class,
            'admin-or-pembimbing' => AdminOrPembimbingMiddleware::class,
            'pimpinan' => PimpinanMiddleware::class,
            'ketua-tim' => KetuaTimMiddleware::class,
            'no-cache' => NoCacheMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
