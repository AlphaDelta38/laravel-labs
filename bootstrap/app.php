<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CommentRoleAccess;
use App\Http\Middleware\ProjectRoleAccess;
use App\Http\Middleware\TaskRoleAccess;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'comment-role-access' => CommentRoleAccess::class,
            'project-role-access' => ProjectRoleAccess::class,
            'task-role-access' => TaskRoleAccess::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

    $exceptions->render(function (\App\Exceptions\AppException $e, $request) {
        return response()->json([
            'error' => $e->getMessage(),
            'code'  => $e->getCode()
        ], $e->getCode());
    });


    $exceptions->render(function (\Throwable $e, $request) {
        return response()->json([
            'error' => $e->getMessage(),
        ], 500);
    });




    })->create();
