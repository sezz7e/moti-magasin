<?php

namespace App\Support;

use App\Models\Product;

class Cart
{
    public static function raw(): array
    {
        return session('cart', []);
    }

    public static function add(Product $product, int $qty = 1): void
    {
        $cart = self::raw();
        $cart[$product->id] = min(($cart[$product->id] ?? 0) + $qty, $product->stock);
        session(['cart' => $cart]);
    }

    public static function set(Product $product, int $qty): void
    {
        $cart = self::raw();

        if ($qty <= 0) {
            unset($cart[$product->id]);
        } else {
            $cart[$product->id] = min($qty, $product->stock);
        }

        session(['cart' => $cart]);
    }

    public static function lines()
    {
        $raw = self::raw();

        return Product::with('collection')
            ->whereIn('id', array_keys($raw))
            ->where('is_active', true)
            ->get()
            ->map(function ($p) use ($raw) {
                $qty = min($raw[$p->id], $p->stock);

                return (object) [
                    'product' => $p,
                    'qty' => $qty,
                    'subtotal' => $p->price * $qty,
                ];
            })
            ->filter(fn ($line) => $line->qty > 0)
            ->values();
    }

    public static function total(): int
    {
        return (int) self::lines()->sum('subtotal');
    }

    public static function count(): int
    {
        return (int) self::lines()->sum('qty');
    }

    public static function shippingFor(int $subtotal): int
    {
        if ($subtotal <= 0) {
            return 0;
        }

        $free = config('store.free_shipping_over');

        return ($free && $subtotal >= $free) ? 0 : (int) config('store.shipping_fee');
    }

    public static function clear(): void
    {
        session()->forget(['cart', 'cart_note']);
    }
}
