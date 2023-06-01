<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backery;
use App\Http\Controllers\CartController;

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

Route::get('/', [Backery::class, 'show']);
Route::get('/catalog', [Backery::class, 'show_catalog']);
Route::get('/information', [Backery::class, 'show_info']);
Route::get('/tovar/{id}', [Backery::class, 'show_tovar']);
Route::post('/tovar/{id}/submit', [Backery::class, 'tovar_comment']);
Route::post('/catalog/submit', [Backery::class, 'catalog_sort']);
Route::get('/catalog/{id}', [Backery::class, 'categories']);
Route::get('/main/{id}', [CartController::class, 'store_main']);
Route::get('/tovar/cart/{id}', [CartController::class, 'store_tovar']);
Route::get('/catalog/cart/{id}', [CartController::class, 'store_catalog']);
Route::get('/cart', [CartController::class, 'cart']);
Route::get('/delete/{id}', [CartController::class, 'delete']);
Route::post('/cart/submit', [CartController::class, 'buying']);
Route::post('/catalog/constructor', [CartController::class, 'constructor']);