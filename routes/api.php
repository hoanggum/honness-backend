<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Feed\LikeController;
use App\Http\Controllers\Post\PostController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', [UserController::class, 'getUser']);
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    // Route::get('/posts/{id}', [PostController::class, 'show']);
    // Route::put('/posts/{id}', [PostController::class, 'update']);
    // Route::delete('/posts/{id}', [PostController::class, 'destroy']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/likes', [LikeController::class, 'likePost']);
    Route::delete('/likes/{id}', [LikeController::class, 'unlike']);
});