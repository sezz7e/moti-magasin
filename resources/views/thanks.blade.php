@extends('layouts.checkout', ['title' => 'Order confirmed'])

@section('content')
<div class="co">
    <div class="co-left">
        <div class="co-left-in">
            <header class="co-head">
                <a href="{{ route('home') }}" class="logo">Moti Atelier</a>
            </header>

            <details class="m-summary">
                <summary><span>Show order summary</span><strong>PKR {{ number_format($order->total) }}</strong></summary>
                <div class="m-summary-body">@include('partials.order-summary')</div>
            </details>

            <div class="confirm">
                <div class="check">&#10003;</div>
                <div>
                    <p class="muted">Order {{ $order->order_number }}</p>
                    <h1>Thank you, {{ \Illuminate\Support\Str::before($order->customer_name, ' ') }}!</h1>
                </div>
            </div>

            <div class="card">
                <h2>Your order is confirmed</h2>
                <p>We'll contact you on <span class="val">{{ $order->phone }}</span> to confirm delivery.</p>
            </div>

            <div class="card">
                <h2>Order details</h2>
                <div class="card-grid">
                    <div>
                        <p><strong class="val">Contact</strong></p>
                        <p>{{ $order->phone }}</p>
                        @if($order->email)<p>{{ $order->email }}</p>@endif
                    </div>
                    <div>
                        <p><strong class="val">Delivery address</strong></p>
                        <p>{{ $order->customer_name }}</p>
                        <p>{{ $order->address }}</p>
                        <p>{{ $order->city }}</p>
                    </div>
                    <div>
                        <p><strong class="val">Payment</strong></p>
                        <p>Cash on delivery &middot; PKR {{ number_format($order->total) }}</p>
                    </div>
                    @if($order->notes)
                        <div>
                            <p><strong class="val">Order note</strong></p>
                            <p>{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="foot-row">
                <span></span>
                <a href="{{ route('home') }}" class="btn">Continue shopping</a>
            </div>
        </div>
    </div>

    <div class="co-right">
        <div class="co-right-in">
            @include('partials.order-summary')
        </div>
    </div>
</div>
@endsection