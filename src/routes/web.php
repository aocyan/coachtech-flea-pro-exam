<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [UserController::class, 'login']);
Route::get('/register', [UserController::class, 'register']);
Route::get('/purchase/address', [UserController::class, 'address']);
Route::get('/', [UserController::class, 'index']);
Route::get('/mypage', [UserController::class, 'profile']);
Route::get('/mypage/profile', [UserController::class, 'edit']);
Route::get('/item', [UserController::class, 'exhibition']);
Route::get('/purchase', [UserController::class, 'purchase']);

Route::get('/sell', [ProductController::class, 'create'])->name('sell.create');
Route::post('/sell/store', [ProductController::class, 'store'])->name('sell.store');