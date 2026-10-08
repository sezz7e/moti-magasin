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

    public function add(Request $request, Product $product)
    {
        abort_unless($product->is_active && $product->stock > 0, 404);

        Cart::add($product, max(1, (int) $request->input('qty', 1)));

        if ($request->expectsJson()) {
            return $this->snapshot();
        }

        return $request->boolean('buy_now')
            ? redirect()->route('checkout')
            : redirect()->route('cart');
    }

    public function update(Request $request, Product $product)
    {
        Cart::set($product, (int) $request->input('qty', 0));

        return $request->expectsJson() ? $this->snapshot() : back();
    }

    public function remove(Request $request, Product $product)
    {
        Cart::set($product, 0);

        return $request->expectsJson() ? $this->snapshot() : back();
    }

    public function clear(Request $request)
    {
        Cart::clear();

        return $request->expectsJson() ? $this->snapshot() : back();
    }

    public function note(Request $request)
    {
        $request->validate(['note' => ['nullable', 'string', 'max:500']]);

        session(['cart_note' => (string) $request->input('note', '')]);

        return response()->json(['ok' => true]);
    }

    private function snapshot()
    {
        $data = ['lines' => Cart::lines(), 'total' => Cart::total()];

        return response()->json([
            'count' => Cart::count(),
            'total' => $data['total'],
            'threshold' => view('partials.cart.threshold', $data)->render(),
            'items' => view('partials.cart.items', $data)->render(),
            'totals' => view('partials.cart.totals', $data)->render(),
        ]);
    }
}
