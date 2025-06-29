<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/sell', [ProductController::class, 'create'])->name('sell.create');
Route::post('/sell/store', [ProductController::class, 'store'])->name('sell.store');
Route::get('/purchase/{item_id}', [ProductController::class, 'index'])->name('purchase.index');
Route::get('/purchase/address/{item_id}', [ProductController::class, 'edit'])->name('purchase.address');
Route::patch('/address/update/{item_id}', [ProductController::class, 'update'])->name('address.update');
Route::post('/purchase/{product}', [ProductController::class, 'purchase'])->name('purchase.store');


Route::get('/', [ItemController::class, 'index'])->name('product.index');
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('product.show');
Route::post('/comments', [ItemController::class, 'store'])->name('likeComment.store');
Route::get('/search', [ItemController::class, 'search'])->name('product.search');


Route::post('/register/store', [UserController::class, 'store'])->name('user.store');
Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage.check');
Route::get('/mypage/profile', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/update', [UserController::class, 'update'])->name('user.update');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login/certification', [UserController::class, 'loginCertification'])->name('login.certification');


Route::get('/checkout', [StripeController::class, 'checkout'])->name('checkout');
Route::get('/payment', [StripeController::class, 'payment'])->name('payment');
Route::post('/charge', [StripeController::class, 'charge'])->name('charge');
Route::get('/thanks', [StripeController::class, 'thanks'])->name('thanks');

Route::get('/transaction/{item_id}',[TransactionController::class, 'index'])->name('transaction.index');