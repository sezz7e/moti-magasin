<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Support\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function show()
    {
        $lines = Cart::lines();

        if ($lines->isEmpty()) {
            return redirect()->route('cart');
        }

        $subtotal = Cart::total();
        $shipping = Cart::shippingFor($subtotal);

        return view('checkout', [
            'lines' => $lines,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $subtotal + $shipping,
        ]);
    }

    public function store(Request $request)
    {
        // Honeypot: real people never fill this hidden field
        if ($request->filled('website')) {
            return redirect()->route('home');
        }

        $request->merge(['phone' => preg_replace('/[\s\-]/', '', (string) $request->phone)]);

        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'regex:/^(\+92|92|0)?3\d{9}$/'],
            'email' => ['nullable', 'email', 'max:150'],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:500'],
        ], [
            'phone.regex' => 'Please enter a valid Pakistani mobile number, e.g. 03XX XXXXXXX.',
        ]);

        $lines = Cart::lines();

        if ($lines->isEmpty()) {
            return redirect()->route('cart');
        }

        $order = DB::transaction(function () use ($data, $lines) {
            $ids = $lines->map(fn ($l) => $l->product->id)->unique()->all();

            $products = Product::whereIn('id', $ids)
                ->where('is_active', true)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // Stock is shared by every option of the same product
            $wanted = $lines->groupBy(fn ($l) => $l->product->id)->map(fn ($g) => $g->sum('qty'));

            foreach ($wanted as $id => $qty) {
                $product = $products[$id] ?? null;

                if (! $product || $qty > $product->stock) {
                    throw ValidationException::withMessages([
                        'cart' => 'Sorry, "' . ($product->name ?? 'an item') . '" is no longer available in that quantity.',
                    ]);
                }
            }

            $subtotal = $lines->sum(fn ($l) => $products[$l->product->id]->price * $l->qty);
            $shipping = Cart::shippingFor($subtotal);

            $order = Order::create($data + [
                'order_number' => 'MA-' . strtoupper(Str::random(6)),
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $subtotal + $shipping,
                'payment_method' => 'cod',
            ]);

            foreach ($lines as $line) {
                $product = $products[$line->product->id];

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $line->qty,
                    'options' => $line->options ?: null,
                ]);

                $product->decrement('stock', $line->qty);
            }

            return $order;
        });

        Cart::clear();
        session(['last_order' => $order->order_number]);

        return redirect()->route('order.thanks', $order->order_number);
    }

    public function thanks(string $number)
    {
        abort_unless(session('last_order') === $number, 404);

        $order = Order::with('items.product')->where('order_number', $number)->firstOrFail();

        return view('thanks', compact('order'));
    }
}