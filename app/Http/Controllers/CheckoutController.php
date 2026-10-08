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
        $request->merge(['phone' => preg_replace('/[\s\-\(\)\.]/', '', (string) $request->phone)]);

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

        $raw = Cart::raw();

        if (empty($raw)) {
            return redirect()->route('cart');
        }

        $order = DB::transaction(function () use ($data, $raw) {
            $products = Product::whereIn('id', array_keys($raw))
                ->where('is_active', true)
                ->lockForUpdate()
                ->get();

            $subtotal = 0;
            $items = [];

            foreach ($products as $product) {
                $qty = $raw[$product->id];

                if ($qty > $product->stock) {
                    throw ValidationException::withMessages([
                        'cart' => "Sorry, \"{$product->name}\" is no longer available in that quantity.",
                    ]);
                }

                $subtotal += $product->price * $qty;
                $items[] = ['product' => $product, 'qty' => $qty];
            }

            if (empty($items)) {
                throw ValidationException::withMessages(['cart' => 'Your cart is empty.']);
            }

            $shipping = Cart::shippingFor($subtotal);

            $order = Order::create($data + [
                'order_number' => 'MA-'.strtoupper(Str::random(6)),
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $subtotal + $shipping,
                'payment_method' => 'cod',
            ]);

            foreach ($items as $item) {
                $order->items()->create([
                    'product_id' => $item['product']->id,
                    'product_name' => $item['product']->name,
                    'price' => $item['product']->price,
                    'quantity' => $item['qty'],
                ]);

                $item['product']->decrement('stock', $item['qty']);
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
