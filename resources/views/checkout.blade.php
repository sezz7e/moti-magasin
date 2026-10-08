@extends('layouts.checkout', ['title' => 'Checkout'])

@section('content')
@php
    $field = fn ($name) => $errors->has($name) ? 'field has-error' : 'field';
@endphp
<div class="co">
    <div class="co-left">
        <div class="co-left-in">
            <header class="co-head">
                <a href="{{ route('home') }}" class="logo">Moti Atelier</a>
            </header>

            <details class="m-summary">
                <summary><span>Show order summary</span><strong>PKR {{ number_format($total) }}</strong></summary>
                <div class="m-summary-body">@include('partials.checkout-summary')</div>
            </details>

            @if($errors->has('cart'))
                <div class="alert">{{ $errors->first('cart') }}</div>
            @elseif($errors->any())
                <div class="alert">Please check the highlighted fields.</div>
            @endif

            <form method="POST" action="{{ route('checkout.store') }}" id="checkout-form">
                @csrf

                <h2 class="sec" style="margin-top:0">Contact</h2>
                <div class="{{ $field('phone') }}">
                    <label for="phone">Mobile number</label>
                    <input id="phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="03XX XXXXXXX"
                           value="{{ old('phone') }}" required>
                    @error('phone')<div class="err">{{ $message }}</div>@enderror
                </div>
                <div class="{{ $field('email') }}">
                    <label for="email">Email (optional)</label>
                    <input id="email" name="email" type="email" autocomplete="email" value="{{ old('email') }}">
                    @error('email')<div class="err">{{ $message }}</div>@enderror
                </div>

                <h2 class="sec">Delivery</h2>
                <div class="{{ $field('customer_name') }}">
                    <label for="customer_name">Full name</label>
                    <input id="customer_name" name="customer_name" type="text" autocomplete="name"
                           value="{{ old('customer_name') }}" required>
                    @error('customer_name')<div class="err">{{ $message }}</div>@enderror
                </div>
                <div class="{{ $field('address') }}">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="2" autocomplete="street-address"
                              placeholder="House, street, area" required>{{ old('address') }}</textarea>
                    @error('address')<div class="err">{{ $message }}</div>@enderror
                </div>
                <div class="{{ $field('city') }}">
                    <label for="city">City</label>
                    <input id="city" name="city" type="text" autocomplete="address-level2"
                           value="{{ old('city') }}" required>
                    @error('city')<div class="err">{{ $message }}</div>@enderror
                </div>
                <div class="{{ $field('notes') }}">
                    <label for="notes">Order note (optional)</label>
                    <textarea id="notes" name="notes" rows="2">{{ old('notes', session('cart_note')) }}</textarea>
                    @error('notes')<div class="err">{{ $message }}</div>@enderror
                </div>

                <h2 class="sec">Shipping method</h2>
                <div class="opt sel">
                    <span>Standard delivery</span>
                    <strong>{{ $shipping > 0 ? 'PKR ' . number_format($shipping) : 'Free' }}</strong>
                </div>

                <h2 class="sec">Payment</h2>
                <div class="opt sel top">
                    <label><input type="radio" checked> Cash on delivery (COD)</label>
                </div>
                <div class="opt-note">Pay in cash when your order arrives. We'll contact you to confirm before shipping.</div>

                <div class="foot-row">
                    <a href="{{ route('cart') }}" class="back">&larr; Return to cart</a>
                    <button type="submit" class="btn" id="place-order">Complete order</button>
                </div>
            </form>
        </div>
    </div>

    <div class="co-right">
        <div class="co-right-in">
            @include('partials.checkout-summary')
        </div>
    </div>
</div>

<script>
document.getElementById('checkout-form').addEventListener('submit', function () {
    var b = document.getElementById('place-order');
    setTimeout(function () {
        b.disabled = true;
    }, 0);
    b.textContent = 'Placing your order…';
});
</script>
@endsection