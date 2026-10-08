@extends('layouts.app')

@section('content')
@php
    $images = $product->getMedia('gallery');
    $onSale = $product->compare_at_price && $product->compare_at_price > $product->price;
@endphp

<!-- Page Title -->
<div class="flat-spacing-16 pb-0">
    <div class="container">
        <div class="page-title border-0">
            <div class="breadcrumbs">
                <ul class="bread-wrap mb-0">
                    <li><a href="{{ route('home') }}" class="text-main-4 link">Home</a></li>
                    <li class="br-line w-12 bg-main"></li>
                    @if($product->collection)
                        <li><a href="{{ route('collection', $product->collection->slug) }}" class="text-main-4 link">{{ $product->collection->name }}</a></li>
                        <li class="br-line w-12 bg-main"></li>
                    @endif
                    <li><p>{{ $product->name }}</p></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Product Detail -->
<section class="themesFlat">
    <div class="tf-main-product section-image-zoom">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="tf-product-media-wrap sticky-top">
                        <div class="thumbs-slider">
                            <div class="flat-wrap-media-product">
                                <div dir="ltr" class="swiper tf-product-media-main" id="gallery-swiper-started">
                                    <div class="swiper-wrapper">
                                        @forelse($images as $image)
                                            <div class="swiper-slide">
                                                <a href="{{ $image->getUrl('large') }}" target="_blank" class="item"
                                                   data-pswp-width="1400" data-pswp-height="1750">
                                                    <img class="tf-image-zoom lazyload" data-zoom="{{ $image->getUrl('large') }}"
                                                         data-src="{{ $image->getUrl('large') }}"
                                                         src="{{ $image->getUrl('large') }}" alt="{{ $product->name }}">
                                                </a>
                                            </div>
                                        @empty
                                            <div class="swiper-slide">
                                                <a href="{{ asset('images/products/product-6.jpg') }}" target="_blank" class="item"
                                                   data-pswp-width="1400" data-pswp-height="1750">
                                                    <img class="tf-image-zoom lazyload" data-zoom="{{ asset('images/products/product-6.jpg') }}"
                                                         data-src="{{ asset('images/products/product-6.jpg') }}"
                                                         src="{{ asset('images/products/product-6.jpg') }}" alt="{{ $product->name }}">
                                                </a>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            @if($images->count() > 1)
                                <div dir="ltr" class="swiper tf-product-media-thumbs" data-preview="4" data-direction="horizontal">
                                    <div class="swiper-wrapper stagger-wrap">
                                        @foreach($images as $image)
                                            <div class="swiper-slide stagger-item">
                                                <div class="item">
                                                    <img data-src="{{ $image->getUrl('card') }}" src="{{ $image->getUrl('card') }}" alt="" class="lazyload">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="tf-product-info-wrap">
                        <div class="tf-zoom-main sticky-top"></div>
                        <div class="tf-product-info-list other-image-zoom">
                            <div class="tf-product-info-heading">
                                <h3 class="product-info-name fw-normal">{{ $product->name }}</h3>
                                <div class="product-info-price">
                                    <div class="price-wrap">
                                        <span class="price-new {{ $onSale ? 'price-on-sale' : '' }} h4">PKR {{ number_format($product->price) }}</span>
                                        @if($onSale)
                                            <span class="price-old compare-at-price fw-normal h6">PKR {{ number_format($product->compare_at_price) }}</span>
                                        @endif
                                    </div>
                                </div>
                                @if($product->description)
                                    <p class="product-infor-sub h6 fw-normal text-main-4">{{ \Illuminate\Support\Str::limit($product->description, 160) }}</p>
                                @endif
                                @if($product->stock > 0 && $product->stock <= 5)
                                    <div class="product-info-progress-sale">
                                        <h6 class="text-hurry-up fw-normal">Only {{ $product->stock }} {{ \Illuminate\Support\Str::plural('item', $product->stock) }} left</h6>
                                        <div class="progress-cart">
                                            <div class="value" style="width: 0%;" data-progress="{{ max(15, 100 - $product->stock * 15) }}"></div>
                                        </div>
                                    </div>
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
                                                    <button type="button" class="btn-quantity btn-decrease"><i class="icon-minus"></i></button>
                                                    <input class="quantity-product" type="text" name="qty" value="1">
                                                    <button type="button" class="btn-quantity btn-increase"><i class="icon-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tf-product-total-quantity">
                                        <div class="group-btn">
                                            <button type="submit" class="tf-btn btn-fill-2 text-uppercase fw-medium animate-btn">
                                                add to bag
                                                <i class="icon-minus d-none d-sm-block"></i>
                                                <span class="price-add d-none d-sm-block">PKR {{ number_format($product->price) }}</span>
                                            </button>
                                        </div>
                                        <button type="submit" name="buy_now" value="1" class="tf-btn w-100 text-uppercase fw-medium">
                                            buy it now
                                        </button>
                                    </div>
                                </form>
                            @else
                                <p class="h5 text-uppercase mt-4">Sold out</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Description -->
<div class="flat-spacing-3">
    <div class="container">
        <div class="widget-accordion wd-product-descriptions">
            <div class="accordion-title" data-bs-target="#description" data-bs-toggle="collapse" aria-expanded="true"
                 aria-controls="description" role="button">
                <span class="icon icon-arrow-right-down"></span>
                <span>Description</span>
            </div>
            <div id="description" class="collapse show widget-desc">
                <div class="accordion-body">
                    <h6 class="text-main-4 fw-normal">{!! nl2br(e($product->description)) !!}</h6>
                </div>
            </div>
        </div>
        <div class="widget-accordion wd-product-descriptions">
            <div class="accordion-title collapsed" data-bs-target="#material" data-bs-toggle="collapse" aria-expanded="false"
                 aria-controls="material" role="button">
                <span class="icon icon-arrow-right-down"></span>
                <span>additional information</span>
            </div>
            <div id="material" class="collapse widget-material">
                <div class="accordion-body">
                    <table class="table-material">
                        <tbody>
                            @if($product->collection)
                                <tr><td class="h6">Collection</td><td class="h6">{{ $product->collection->name }}</td></tr>
                            @endif
                            <tr><td class="h6">Availability</td><td class="h6">{{ $product->stock > 0 ? 'In stock' : 'Sold out' }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- You may also like -->
@if($related->isNotEmpty())
<section class="flat-spacing-3">
    <div class="container">
        <div class="sect-top wow fadeInUp">
            <h3 class="s-title">YOU MAY ALSO LIKE</h3>
            <div class="group-btn-slider">
                <div class="nav-prev-swiper tf-sw-nav"><i class="icon-arrow-left"></i></div>
                <div class="nav-next-swiper tf-sw-nav"><i class="icon-arrow-right"></i></div>
            </div>
        </div>
        <div dir="ltr" class="swiper tf-swiper wow fadeInUp" data-preview="4" data-tablet="3" data-mobile-sm="2" data-mobile="2"
             data-space-lg="30" data-space-md="20" data-space="15" data-pagination="2" data-pagination-sm="2" data-pagination-md="3"
             data-pagination-lg="4">
            <div class="swiper-wrapper">
                @foreach($related as $item)
                    <div class="swiper-slide">
                        <div class="card_product--V01">
                            <div class="card_product-wrapper">
                                <a href="{{ route('product', $item->slug) }}" class="product-img">
                                    @if($item->getFirstMediaUrl('gallery'))
                                        <img src="{{ $item->getFirstMediaUrl('gallery', 'card') }}" data-src="{{ $item->getFirstMediaUrl('gallery', 'card') }}" alt="{{ $item->name }}" class="lazyload img-product">
                                        <img src="{{ $item->getFirstMediaUrl('gallery', 'large') }}" data-src="{{ $item->getFirstMediaUrl('gallery', 'large') }}" alt="{{ $item->name }}" class="lazyload img-hover">
                                    @else
                                        <img src="{{ asset('images/products/product-6.jpg') }}" alt="{{ $item->name }}" class="img-product">
                                    @endif
                                </a>
                                @if($item->stock > 0)
                                    <ul class="list-product-btn">
                                        <li>
                                            <form method="POST" action="{{ route('cart.add', $item) }}" data-ajax-cart>
                                                @csrf
                                                <button type="submit" class="hover-tooltip tooltip-left box-icon" style="border:0;">
                                                    <span class="icon icon-shop-cart"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                            <div class="card_product-info">
                                <a href="{{ route('product', $item->slug) }}" class="name-product h5 fw-normal link text-line-clamp-2">{{ $item->name }}</a>
                                <div class="price-wrap">
                                    @if($item->stock > 0)
                                        <span class="price-new h5">PKR {{ number_format($item->price) }}</span>
                                        @if($item->compare_at_price && $item->compare_at_price > $item->price)
                                            <span class="price-old fw-normal">PKR {{ number_format($item->compare_at_price) }}</span>
                                        @endif
                                    @else
                                        <span>Sold out</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="sw-dot-default tf-sw-pagination d-xl-none"></div>
        </div>
    </div>
</section>
@endif

<script>
window.addEventListener('load', function () {
    var mainEl = document.getElementById('gallery-swiper-started');
    var thumbsEl = document.querySelector('.tf-product-media-thumbs');
    if (!window.Swiper || !mainEl || mainEl.swiper) return;

    var thumbs = thumbsEl && !thumbsEl.swiper
        ? new Swiper(thumbsEl, { slidesPerView: 4, spaceBetween: 10, freeMode: true, watchSlidesProgress: true })
        : null;

    new Swiper(mainEl, {
        spaceBetween: 10,
        thumbs: thumbs ? { swiper: thumbs } : undefined,
    });
});
</script>
@endsection