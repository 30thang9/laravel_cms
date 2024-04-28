<?php

use App\Http\Controllers\api\AuthApiController;
use App\Http\Controllers\api\PostApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthApiController::class, 'register'])->name('api.register');
Route::post('/login', [AuthApiController::class, 'login'])->name('api.login');

Route::group(['middleware' => ['auth:sanctum']], function () {
// private post routes
    Route::get('/posts/list', [PostApiController::class, 'list']);
    Route::get('/users/{userId}/posts', [PostApiController::class, 'getByUserId']);
    Route::post('/posts', [PostApiController::class, 'store']);
    Route::put('/posts/{id}', [PostApiController::class, 'update']);
    Route::delete('/posts/{id}', [PostApiController::class, 'destroy']);

// logout
    Route::post('/logout', [AuthApiController::class, 'logout']);
});
