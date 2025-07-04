<?php
// require __DIR__.'/../vendor/autoload.php';

use App\Http\Middleware\CartMiddleware;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\PreventDirectAccess;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        )
        ->withMiddleware(function (Middleware $middleware) {
       // Đăng ký alias
       $middleware->alias([
        'admin' => CheckRole::class,
        'cart' => CartMiddleware::class,
        'preventDirectAccess' => PreventDirectAccess::class,
    ]);

    // Áp dụng CartMiddleware cho nhóm web
    $middleware->web([  
        CartMiddleware::class,
    ]);
     $middleware->api([
            HandleCors::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // 
        
    })->create();
