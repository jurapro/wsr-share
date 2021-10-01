<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

Route::post('login',[UserController::class, 'login']);
Route::post('signup',[UserController::class, 'signup']);
Route::get('products',[ProductController::class, 'index']);
Route::get('logout',[UserController::class, 'logout'])->middleware('auth:api');

Route::post('cart/{product}', [CartController::class, 'add'])->middleware('auth:api');
Route::delete('cart/{cart}', [CartController::class, 'remove'])->middleware('auth:api');
Route::get('cart', [CartController::class, 'index'])->middleware('auth:api');

Route::post('order', [OrderController::class, 'add'])->middleware('auth:api');
Route::get('order', [OrderController::class, 'index'])->middleware('auth:api');
