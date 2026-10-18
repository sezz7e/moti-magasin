<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StoreController;

Route::get('/', [StoreController::class, 'home'])->name('home');
Route::get('/shop/{slug}', [StoreController::class, 'collection'])->name('collection');
Route::get('/products/{slug}', [StoreController::class, 'product'])->name('product');
Route::view('/about', 'about')->name('about');
Route::get('/shop', [StoreController::class, 'shop'])->name('shop');



// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{line}', [CartController::class, 'update'])->where('line', '[0-9]+-[a-f0-9]{8}')->name('cart.update');
Route::delete('/cart/{line}', [CartController::class, 'remove'])->where('line', '[0-9]+-[a-f0-9]{8}')->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/note', [CartController::class, 'note'])->name('cart.note');

// Checkout routes
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->middleware('throttle:5,1')->name('checkout.store');
Route::get('/order/{number}', [CheckoutController::class, 'thanks'])->name('order.thanks');

Route::get('/products/{slug}/quick-view', [StoreController::class, 'quickView'])->name('product.quick');
Route::get('/search', [StoreController::class, 'search'])->name('search');
Route::get('/search/suggest', [StoreController::class, 'suggest'])->middleware('throttle:60,1')->name('search.suggest');

