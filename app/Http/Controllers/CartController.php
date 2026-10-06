<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart', [
            'lines' => Cart::lines(),
            'total' => Cart::total(),
        ]);
    }

    public function add(Product $product)
    {
        abort_unless($product->is_active && $product->stock > 0, 404);

        Cart::add($product);

        return redirect()->route('cart');
    }

    public function update(Request $request, Product $product)
    {
        Cart::set($product, (int) $request->input('qty', 0));

        return back();
    }

    public function remove(Product $product)
    {
        Cart::set($product, 0);

        return back();
    }
}