<?php

namespace App\Support;

use App\Models\Product;
use Illuminate\Validation\ValidationException;

class Cart
{
    /** Cart contents as [lineKey => ['id' => productId, 'qty' => n, 'options' => [...]]] */
    public static function raw(): array
    {
        $clean = [];

        foreach (session('cart', []) as $key => $row) {
            if (is_array($row)) {
                $clean[$key] = [
                    'id' => (int) $row['id'],
                    'qty' => (int) $row['qty'],
                    'options' => (array) ($row['options'] ?? []),
                ];
            } else {
                // Older carts stored just productId => quantity
                $clean[self::key((int) $key, [])] = ['id' => (int) $key, 'qty' => (int) $row, 'options' => []];
            }
        }

        return $clean;
    }

    public static function key(int $productId, array $options): string
    {
        ksort($options);

        return $productId . '-' . substr(md5(json_encode($options)), 0, 8);
    }

    /** Validate what the customer picked against what the product really offers. */
    public static function resolveOptions(Product $product, array $input): array
    {
        $chosen = [];

        foreach ($product->optionGroups() as $name => $group) {
            $value = $input[$name] ?? null;

            if (is_string($value) && in_array($value, $group['values'], true)) {
                $chosen[$name] = $value;
            } elseif (count($group['values']) === 1) {
                $chosen[$name] = $group['values'][0];
            } else {
                throw ValidationException::withMessages([
                    'options' => 'Please choose a ' . strtolower($group['label']) . '.',
                ]);
            }
        }

        return $chosen;
    }

    public static function add(Product $product, int $qty = 1, array $options = []): void
    {
        $cart = self::raw();
        $key = self::key($product->id, $options);

        $cart[$key] = [
            'id' => $product->id,
            'qty' => ($cart[$key]['qty'] ?? 0) + $qty,
            'options' => $options,
        ];

        self::cap($cart, $product, $key);
        session(['cart' => $cart]);
    }

    public static function set(string $key, int $qty): void
    {
        $cart = self::raw();

        if (! isset($cart[$key])) {
            return;
        }

        $product = $qty > 0 ? Product::find($cart[$key]['id']) : null;

        if (! $product) {
            unset($cart[$key]);
        } else {
            $cart[$key]['qty'] = $qty;
            self::cap($cart, $product, $key);
        }

        session(['cart' => $cart]);
    }

    /** Stock is shared by every option line of the same product. */
    private static function cap(array &$cart, Product $product, string $key): void
    {
        $others = 0;

        foreach ($cart as $k => $row) {
            if ($k !== $key && $row['id'] === $product->id) {
                $others += $row['qty'];
            }
        }

        $cart[$key]['qty'] = min($cart[$key]['qty'], max(0, $product->stock - $others));

        if ($cart[$key]['qty'] <= 0) {
            unset($cart[$key]);
        }
    }

    public static function lines()
    {
        $raw = self::raw();

        $products = Product::with('collection')
            ->whereIn('id', collect($raw)->pluck('id')->unique()->all())
            ->where('is_active', true)
            ->get()
            ->keyBy('id');

        $left = $products->map(fn ($p) => $p->stock)->all();
        $used = [];
        $lines = [];

        foreach ($raw as $key => $row) {
            $product = $products[$row['id']] ?? null;

            if (! $product) {
                continue;
            }

            $qty = min($row['qty'], $left[$product->id]);

            if ($qty <= 0) {
                continue;
            }

            $left[$product->id] -= $qty;
            $used[$product->id] = ($used[$product->id] ?? 0) + $qty;

            $lines[] = (object) [
                'key' => $key,
                'product' => $product,
                'qty' => $qty,
                'options' => $row['options'],
                'optionsLabel' => implode(' · ', $row['options']),
                'subtotal' => $product->price * $qty,
            ];
        }

        foreach ($lines as $line) {
            $line->canIncrease = $used[$line->product->id] < $line->product->stock;
        }

        return collect($lines);
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