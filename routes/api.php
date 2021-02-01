<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [\App\Http\Controllers\API\AuthController::class, 'register'])->name('api_register');
Route::post('login', [\App\Http\Controllers\API\AuthController::class, 'login'])->name('api_login');
Route::post('logout', [\App\Http\Controllers\API\AuthController::class, 'logout'])->middleware('auth:api')->name('api_logout');

Route::get('blogs/my_blogs', [\App\Http\Controllers\API\BlogController::class, 'my_blogs'])->middleware('auth:api')->name('blogs.my_blogs');
Route::get('blogs/user_blogs/{user_id}', [\App\Http\Controllers\API\BlogController::class, 'user_blogs'])->middleware('auth:api')->name('blogs.user_blogs');
Route::apiResource('blogs', \App\Http\Controllers\API\BlogController::class)->middleware('auth:api');

