@php
    $images = $product->getMedia('gallery');
    $onSale = $product->compare_at_price && $product->compare_at_price > $product->price;
    $percent = $onSale ? round((1 - $product->price / $product->compare_at_price) * 100) : 0;
@endphp
<div class="tf-product-media-wrap tf-btn-swiper-item">
    <div dir="ltr" class="swiper tf-single-slide" id="qv-slider">
        <div class="swiper-wrapper">
            @forelse($images as $img)
                <div class="swiper-slide">
                    <div class="item"><img src="{{ $img->getUrl('large') }}" alt="{{ $product->name }}"></div>
                </div>
            @empty
                <div class="swiper-slide">
                    <div class="item"><img src="{{ asset('images/products/product-6.jpg') }}" alt="{{ $product->name }}"></div>
                </div>
            @endforelse
        </div>
        @if($images->count() > 1)
            <div class="nav-swiper-group style-3">
                <div class="nav-thumbs thumbs-prev single-slide-prev"><span class="fw-normal">PRE</span></div>
                <span class="text-main">/</span>
                <div class="nav-thumbs thumbs-next single-slide-next"><span class="fw-normal">NEXT</span></div>
            </div>
        @endif
    </div>
</div>

<div class="tf-product-info-wrap">
    <div class="tf-product-info-inner tf-product-info-list">
        <div class="tf-product-info-heading">
            <a href="{{ route('product', $product->slug) }}" class="product-info-name h4 fw-normal text-uppercase link">{{ $product->name }}</a>
            <div class="product-info-price">
                <div class="price-wrap">
                    <span class="price-new {{ $onSale ? 'price-on-sale' : '' }} h4">PKR {{ number_format($product->price) }}</span>
                    @if($onSale)
                        <span class="price-old compare-at-price fw-normal h6">PKR {{ number_format($product->compare_at_price) }}</span>
                        <p class="badges-on-sale">
                            <i class="icon-tag"></i>
                            <span class="number-sale">{{ $percent }}% OFF</span>
                        </p>
                    @endif
                </div>
            </div>
            @if($product->description)
                <p class="product-infor-sub text-main-4">{{ \Illuminate\Support\Str::limit($product->description, 220) }}</p>
            @endif
        </div>

        @if($product->stock > 0)
            <form method="POST" action="{{ route('cart.add', $product) }}" data-ajax-cart>
                @csrf
                <div class="tf-product-info-variant">
                    <div class="variant-picker-item">
                        <div class="variant-picker-label h6 fw-normal">Quantity</div>
                        <div class="variant-picker-values">
                            <div class="wg-quantity">
                                <button type="button" class="btn-quantity" data-qv-step="-1" aria-label="Decrease"><i class="icon-minus"></i></button>
                                <input class="quantity-product" type="text" name="qty" value="1" max="{{ $product->stock }}" readonly>
                                <button type="button" class="btn-quantity" data-qv-step="1" aria-label="Increase"><i class="icon-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tf-product-total-quantity">
                    <div class="group-btn">
                        <button type="submit" class="tf-btn btn-fill-2 animate-btn text-uppercase fw-medium">
                            <span class="text-line-clamp-1">add to bag</span>
                            <i class="icon-minus d-none d-sm-block"></i>
                            <span class="price-add d-none d-sm-block">PKR {{ number_format($product->price) }}</span>
                        </button>
                    </div>
                    <button type="submit" name="buy_now" value="1" class="tf-btn w-100 text-uppercase fw-medium">buy it now</button>
                </div>
            </form>
        @else
            <p class="h5 text-uppercase my-4">Sold out</p>
        @endif

        <a href="{{ route('product', $product->slug) }}" class="tf-btn-line">
            <span class="text-body">View full details</span>
            <i class="icon icon-arrow-top-right"></i>
        </a>
    </div>
</div>