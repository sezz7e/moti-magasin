<div class="card_product--V01">
    <div class="card_product-wrapper">
        <a href="{{ route('product', $product->slug) }}" class="product-img">
            @if($product->getFirstMediaUrl('gallery'))
                <img src="{{ $product->getFirstMediaUrl('gallery', 'card') }}" alt="{{ $product->name }}" class="img-product">
                <img src="{{ $product->getFirstMediaUrl('gallery', 'large') }}" alt="{{ $product->name }}" class="img-hover">
            @else
                <img src="{{ asset('images/products/product-6.jpg') }}" alt="{{ $product->name }}" class="img-product">
            @endif
        </a>
        <ul class="list-product-btn">
            @if($product->stock > 0)
                <li>
                    <form method="POST" action="{{ route('cart.add', $product) }}" data-ajax-cart>
                        @csrf
                        <button type="submit" class="hover-tooltip tooltip-left box-icon" style="border:0;">
                            <span class="icon icon-shop-cart"></span><span class="tooltip">Add to Cart</span>
                        </button>
                    </form>
                </li>
            @endif
            <li>
                <a href="javascript:void(0);" class="hover-tooltip tooltip-left box-icon" data-quick-view="{{ route('product.quick', $product->slug) }}">
                    <span class="icon icon-view"></span><span class="tooltip">Quick View</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="card_product-info">
        <a href="{{ route('product', $product->slug) }}" class="name-product h5 fw-normal link text-line-clamp-2">{{ $product->name }}</a>
        <div class="price-wrap">
            @if($product->stock > 0)
                <span class="price-new h5">PKR {{ number_format($product->price) }}</span>
                @if($product->compare_at_price && $product->compare_at_price > $product->price)
                    <span class="price-old fw-normal">PKR {{ number_format($product->compare_at_price) }}</span>
                @endif
            @else
                <span>Sold out</span>
            @endif
        </div>
    </div>
</div>
