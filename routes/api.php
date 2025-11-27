<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\CommentController;


Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);

    // Projects
    Route::apiResource('/projects', ProjectController::class);
    Route::post('/projects/{project}/tasks', [ProjectController::class, 'storeTask']);
    Route::get('/projects/{project}/tasks', [ProjectController::class, 'indexTasks']);

    // Tasks
    Route::apiResource('/tasks', TasksController::class);
    Route::post('/tasks/{task}/comments', [TasksController::class, 'storeComment']);
    Route::get('/tasks/{task}/comments', [TasksController::class, 'indexComments']);

    // Comments
    Route::apiResource('/comments', CommentController::class);

});
 