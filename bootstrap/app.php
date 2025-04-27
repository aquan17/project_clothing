<?php
// require __DIR__.'/../vendor/autoload.php';

use App\Http\Middleware\CartMiddleware;
use App\Http\Middleware\CheckRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        // admin: __DIR__.'/../routes/admin.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        )
        ->withMiddleware(function (Middleware $middleware) {
       // Đăng ký alias
       $middleware->alias([
        'admin' => CheckRole::class,
        'cart' => CartMiddleware::class,
    ]);

    // Áp dụng CartMiddleware cho nhóm web
    $middleware->web([
        CartMiddleware::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
