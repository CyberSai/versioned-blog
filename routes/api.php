<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('{version}')->where(['version' => '\d+'])->group(function () {
    Route::apiResource('users', UserController::class)->only('store');

    Route::middleware('auth:api')->group(function () {
        Route::apiResource('users', UserController::class)->only(['index', 'show']);
        Route::apiResource('users.posts', PostController::class)
            ->only(['index', 'store', 'show'])->scoped()->shallow();
    });

    Route::apiResource('categories', CategoryController::class)->only('index');
});
