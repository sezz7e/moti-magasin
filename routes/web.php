<?php

use App\Http\Controllers\StoreController;

Route::get('/', [StoreController::class, 'home'])->name('home');
Route::get('/collections/{slug}', [StoreController::class, 'collection'])->name('collection');
Route::get('/products/{slug}', [StoreController::class, 'product'])->name('product');