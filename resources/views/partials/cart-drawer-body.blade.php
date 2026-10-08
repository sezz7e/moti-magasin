@if($lines->isEmpty())
    <p class="text-center py-5">Your cart is empty.</p>
@else
    <ul class="list-unstyled m-0">
        @foreach($lines as $line)
            <li class="d-flex gap-3 py-3 border-bottom align-items-center">
                <a href="{{ route('product', $line->product->slug) }}" style="width:72px;flex-shrink:0;">
                    <img src="{{ $line->product->getFirstMediaUrl('gallery', 'card') ?: asset('images/products/product-6.jpg') }}" alt="" class="w-100">
                </a>
                <div class="flex-grow-1">
                    <a href="{{ route('product', $line->product->slug) }}" class="link h6 d-block mb-1">{{ $line->product->name }}</a>
                    <div class="small mb-2">PKR {{ number_format($line->product->price) }}</div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm border" data-cart-qty
                                data-url="{{ route('cart.update', $line->product) }}" data-qty="{{ $line->qty - 1 }}">&minus;</button>
                        <span>{{ $line->qty }}</span>
                        <button type="button" class="btn btn-sm border" data-cart-qty
                                data-url="{{ route('cart.update', $line->product) }}" data-qty="{{ $line->qty + 1 }}"
                                @disabled($line->qty >= $line->product->stock)>+</button>
                    </div>
                </div>
                <div class="text-end">
                    <div>PKR {{ number_format($line->subtotal) }}</div>
                    <button type="button" class="btn btn-link btn-sm p-0" data-cart-remove
                            data-url="{{ route('cart.remove', $line->product) }}">Remove</button>
                </div>
            </li>
        @endforeach
    </ul>

    <div class="d-flex justify-content-between py-3 h5">
        <span>Total</span><span>PKR {{ number_format($total) }}</span>
    </div>
    <a href="{{ route('cart') }}" class="tf-btn w-100 mb-2">View cart</a>
    <a href="{{ route('checkout') }}" class="tf-btn btn-fill w-100">Checkout</a>
@endif