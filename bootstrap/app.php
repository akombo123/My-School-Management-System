<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CommonMiddleware;
use App\Http\Middleware\ParentMiddleware;
use App\Http\Middleware\StudentMiddleware;
use App\Http\Middleware\TeacherMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;






return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
        'admin'=>AdminMiddleware::class,
        'teacher'=>TeacherMiddleware::class,
        'student'=>StudentMiddleware::class,
        'parent'=>ParentMiddleware::class,
        'common'=>CommonMiddleware::class,
        ]);
        $middleware->validateCsrfTokens(except: [
                'parent/my-student/fee-collection/*',
                'payments',

    ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
