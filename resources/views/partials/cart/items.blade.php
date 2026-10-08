@if($lines->isEmpty())
    <div class="p-5 text-center">
        <p class="h6 fw-normal">Your cart is empty.</p>
        <a href="{{ route('home') }}" class="tf-btn btn-fill animate-btn mt-4"><span class="fw-medium">CONTINUE SHOPPING</span></a>
    </div>
@else
    <ul class="tf-mini-cart-items">
        @foreach($lines as $line)
            <li class="tf-mini-cart-item">
                <div class="tf-mini-cart-image">
                    <img src="{{ $line->product->getFirstMediaUrl('gallery', 'card') ?: asset('images/products/product-6.jpg') }}" alt="{{ $line->product->name }}">
                </div>
                <div class="tf-mini-cart-info">
                    <a href="{{ route('product', $line->product->slug) }}" class="prd-name link">{{ $line->product->name }}</a>
                    @if($line->product->collection)
                        <p class="type-select text-main-4">{{ $line->product->collection->name }}</p>
                    @endif
                    <div class="prd-quantity">
                        <p class="text-caption">Qty:</p>
                        <div class="wg-quantity style-2">
                            <button type="button" class="btn-quantity" data-cart-qty
                                    data-url="{{ route('cart.update', $line->product) }}" data-qty="{{ $line->qty - 1 }}"><i class="icon-minus"></i></button>
                            <input class="quantity-product" type="text" value="{{ $line->qty }}" readonly>
                            <button type="button" class="btn-quantity" data-cart-qty
                                    data-url="{{ route('cart.update', $line->product) }}" data-qty="{{ $line->qty + 1 }}"
                                    @disabled($line->qty >= $line->product->stock)><i class="icon-plus"></i></button>
                        </div>
                    </div>
                    <a href="javascript:void(0)" class="tf-btn-line style-line-2" data-cart-remove
                       data-url="{{ route('cart.remove', $line->product) }}"><span class="text-caption">Remove</span></a>
                </div>
                <p class="tf-mini-card-price h6 fw-normal">PKR {{ number_format($line->subtotal) }}</p>
            </li>
        @endforeach
    </ul>
@endif