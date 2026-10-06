<?php

use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;

Route::get('/', [StoreController::class, 'home'])->name('home');
Route::get('/collections/{slug}', [StoreController::class, 'collection'])->name('collection');
Route::get('/products/{slug}', [StoreController::class, 'product'])->name('product');


// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');