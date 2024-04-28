<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login',[AuthController::class,'loginView'] );
Route::get('/register',[AuthController::class,'registerView'] );
Route::get('/register',[AuthController::class,'registerView'] );
Route::get('/users/{userId}/posts', [PostController::class, 'userPosts']);
Route::get('/posts', [PostController::class, 'addPost']);

//session
Route::get('/set-session', function () {
    session()->put('name', 'The Huong');
    return 'Session started';
});
Route::get('/get-session', function () {
    $name = session('name') ?? 'Nothing';
    return $name;
});
Route::get('/delete-session', function () {
    session()->forget('name');
    return 'Session deleted';
});

//cookies
Route::get('/set-cookie', function () {
    return response('Hello World')->cookie('username', 'The Huong', 60);
});
Route::get('/get-cookie', function (Request $request) {
    $username = $request->cookie('username') ?? 'Nothing';
    return $username;
});
Route::get('/delete-cookie', function () {
    return response('Goodbye')->cookie('username', '', 0);
});

//
Route::get('/store-data', function () {
    session(['user_id' => 1]);
    return 'Data stored in session';
});
Route::get('/retrieve-data', function () {
    $userId = session('user_id');
    return $userId;
});
