@extends('layouts.app')

@section('content')
<section class="px-6 md:px-12 py-28 text-center max-w-2xl mx-auto">
    <p class="text-xs tracking-[0.4em] uppercase text-gold">Thank you</p>
    <h1 class="font-serif text-5xl mt-6">Order placed</h1>
    <p class="mt-6 text-ink/70">Your order number is <strong>{{ $order->order_number }}</strong>.
        We'll contact you on {{ $order->phone }} to confirm delivery.</p>

    <div class="mt-10 text-sm text-left divide-y divide-ink/10">
        @foreach($order->items as $item)
            <div class="flex justify-between py-3">
                <span>{{ $item->product_name }} &times; {{ $item->quantity }}</span>
                <span>PKR {{ number_format($item->price * $item->quantity) }}</span>
            </div>
        @endforeach
        <div class="flex justify-between py-3"><span>Shipping</span><span>PKR {{ number_format($order->shipping) }}</span></div>
        <div class="flex justify-between py-3 font-serif text-xl"><span>Total (pay on delivery)</span><span>PKR {{ number_format($order->total) }}</span></div>
    </div>

    <a href="{{ route('home') }}" class="inline-block mt-10 underline hover:text-gold">Continue shopping</a>
</section>
@endsection