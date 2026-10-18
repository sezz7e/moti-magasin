@extends('layouts.app')

@section('content')
<div class="flat-spacing-16 pb-0">
    <div class="container">
        <div class="page-title border-0">
            <div class="breadcrumbs">
                <ul class="bread-wrap mb-0">
                    <li><a href="{{ route('home') }}" class="text-main-4 link">Home</a></li>
                    <li class="br-line w-12 bg-main"></li>
                    <li><p>Shopping cart</p></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="flat-spacing-3">
    <div class="container" style="max-width: 900px;">
        <h1 class="fw-normal text-center mb-5">Shopping cart</h1>

        @if($lines->isEmpty())
            <p class="text-center">Your cart is empty.</p>
            <p class="text-center mt-4"><a href="{{ route('home') }}" class="tf-btn btn-fill animate-btn"><span class="fw-medium">CONTINUE SHOPPING</span></a></p>
        @else
            <div class="border-top">
                @foreach($lines as $line)
                    <div class="d-flex gap-3 align-items-center py-4 border-bottom">
                        <a href="{{ route('product', $line->product->slug) }}" style="width:96px;flex-shrink:0;">
                            <img src="{{ $line->product->getFirstMediaUrl('gallery', 'card') ?: asset('images/products/product-6.jpg') }}" alt="" class="w-100">
                        </a>
                        <div class="flex-grow-1">
                            <a href="{{ route('product', $line->product->slug) }}" class="h5 fw-normal link">{{ $line->product->name }}</a>
                            @if($line->optionsLabel)
                                <p class="text-main-4 mb-1">{{ $line->optionsLabel }}</p>
                            @endif
                            <div>PKR {{ number_format($line->product->price) }}</div>
                            <form method="POST" action="{{ route('cart.update', $line->key) }}" class="d-flex gap-3 align-items-center mt-2">
                                @csrf @method('PATCH')
                                <input type="number" name="qty" value="{{ $line->qty }}" min="1" max="{{ $line->product->stock }}"
                                       class="form-control" style="width:80px;">
                                <button class="tf-btn-line"><span class="text-body">Update</span></button>
                            </form>
                        </div>
                        <div class="text-end">
                            <div class="h6 fw-normal">PKR {{ number_format($line->subtotal) }}</div>
                            <form method="POST" action="{{ route('cart.remove', $line->key) }}" class="mt-2">
                                @csrf @method('DELETE')
                                <button class="tf-btn-line"><span class="text-caption">Remove</span></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <span class="h4 fw-normal">Subtotal</span>
                <span class="h4 fw-normal">PKR {{ number_format($total) }}</span>
            </div>
            <p class="text-main-4 text-end">Cash on delivery. Shipping is calculated at checkout.</p>
            <div class="text-end mt-4">
                <a href="{{ route('checkout') }}" class="tf-btn btn-fill animate-btn"><span class="fw-medium">CHECKOUT</span></a>
            </div>
        @endif
    </div>
</section>
@endsection