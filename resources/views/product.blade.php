@extends('layouts.app')

@section('content')
@php
    $images = $product->getMedia('gallery');
    $onSale = $product->compare_at_price && $product->compare_at_price > $product->price;
    $percent = $onSale ? round((1 - $product->price / $product->compare_at_price) * 100) : 0;
    $desc = trim((string) $product->description);
    $teaser = \Illuminate\Support\Str::limit($desc, 160);
    $hasLongDescription = mb_strlen($desc) > 160;
    $swatchColors = [
        'metal' => config('store.metal_swatches', []),
        'stone' => config('store.stone_colors', []),
    ];
    $freeOver = config('store.free_shipping_over');

    // Real photo sizes for the zoom lightbox (falls back to a 4:5 portrait)
    $dims = function ($media) {
        $size = @getimagesize($media->getPath('large'));

        return [$size[0] ?? 1400, $size[1] ?? 1750];
    };
@endphp

{{-- Tailwind's `.collapse { visibility: collapse }` conflicts with Bootstrap Collapse --}}
<style>
    .tf-product-accordion .collapse,
    .tf-product-accordion .collapsing {
        visibility: visible !important;
    }
</style>

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
<section class="flat-spacing pt-0">
    <div class="tf-main-product section-image-zoom">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="wrapper-gallery-scroll flat-single-grid flat-single-stacked" id="gallery-started">
                        @forelse($images as $image)
                            @php [$w, $h] = $dims($image); @endphp
                            <a href="{{ $image->getUrl('large') }}" target="_blank" class="item"
                               data-pswp-width="{{ $w }}" data-pswp-height="{{ $h }}">
                                <img class="tf-image-zoom lazyload" data-zoom="{{ $image->getUrl('large') }}"
                                     data-src="{{ $image->getUrl('large') }}" src="{{ $image->getUrl('large') }}"
                                     alt="{{ $product->name }}">
                            </a>
                        @empty
                            <a href="{{ asset('images/products/product-6.jpg') }}" target="_blank" class="item"
                               data-pswp-width="1400" data-pswp-height="1750">
                                <img class="tf-image-zoom lazyload" data-zoom="{{ asset('images/products/product-6.jpg') }}"
                                     data-src="{{ asset('images/products/product-6.jpg') }}" src="{{ asset('images/products/product-6.jpg') }}"
                                     alt="{{ $product->name }}">
                            </a>
                        @endforelse
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="tf-product-info-wrap sticky-top">
                        <div class="tf-zoom-main sticky-top"></div>

                        <div class="tf-product-info-list other-image-zoom mb_48">
                            <div class="tf-product-info-heading">
                                <h3 class="product-info-name fw-normal">{{ $product->name }}</h3>
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
                                @if($desc)
                                    <p class="product-infor-sub h6 fw-normal text-main-4">{{ $teaser }}</p>
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
                                        @foreach($product->optionGroups() as $name => $group)
                                            @php
                                                $single = count($group['values']) === 1;
                                                $isSwatch = in_array($name, ['metal', 'stone'], true);
                                            @endphp

                                            <div class="variant-picker-item {{ $isSwatch ? 'variant-color' : 'variant-size' }}">
                                                <div class="variant-picker-label h6 fw-normal">
                                                    {{ $group['label'] }}:
                                                    <span class="variant-picker-label-value" data-option-value="{{ $name }}">{{ $single ? $group['values'][0] : '' }}</span>
                                                </div>

                                                @if($isSwatch)
                                                    <div class="variant-picker-values" data-option-group="{{ $name }}">
                                                        @foreach($group['values'] as $value)
                                                            @php $bg = $swatchColors[$name][$value] ?? '#cfc8bb'; @endphp
                                                            <div class="hover-tooltip color-btn style-image-square {{ $single ? 'active' : '' }}"
                                                                 role="button" tabindex="0" data-option-pick="{{ $value }}">
                                                                <span class="check-color">
                                                                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
                                                                         alt="{{ $value }}" style="background: {{ $bg }};">
                                                                </span>
                                                                <span class="tooltip">{{ $value }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="variant-picker-values">
                                                        <div class="btn-group" data-option-group="{{ $name }}">
                                                            @foreach($group['values'] as $value)
                                                                <span class="size-btn {{ $single ? 'active' : '' }}" role="button" tabindex="0"
                                                                      data-option-pick="{{ $value }}">{{ $value }}</span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                                <input type="hidden" name="options[{{ $name }}]" value="{{ $single ? $group['values'][0] : '' }}"
                                                       data-label="{{ strtolower($group['label']) }}">
                                            </div>
                                        @endforeach

                                        <p class="text-danger small mb-3" data-option-error>@error('options'){{ $message }}@enderror</p>

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
                                            <button type="submit" class="tf-btn btn-fill-2 animate-btn text-uppercase fw-medium">
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

                        <div class="tf-product-accordion">
                            @if($hasLongDescription)
                                <div class="widget-accordion-2 style-3">
                                    <div class="accordion-title collapsed" data-bs-target="#pd-description" data-bs-toggle="collapse"
                                         aria-expanded="false" aria-controls="pd-description" role="button">
                                        <span>Description</span>
                                        <span class="icon ic-accordion-custom"></span>
                                    </div>
                                    <div id="pd-description" class="collapse widget-desc">
                                        <div class="accordion-body">
                                            <h6 class="text-main-4 fw-normal">{!! nl2br(e($desc)) !!}</h6>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="widget-accordion-2 style-3">
                                <div class="accordion-title collapsed" data-bs-target="#pd-info" data-bs-toggle="collapse"
                                     aria-expanded="false" aria-controls="pd-info" role="button">
                                    <span>additional information</span>
                                    <span class="icon ic-accordion-custom"></span>
                                </div>
                                <div id="pd-info" class="collapse widget-material">
                                    <div class="accordion-body">
                                        <table class="table-material">
                                            <tbody>
                                                @if($product->collection)
                                                    <tr><td class="h6">Collection</td><td class="h6">{{ $product->collection->name }}</td></tr>
                                                @endif
                                                @if(!empty($product->metals))
                                                    <tr><td class="h6">Metal</td><td class="h6">{{ implode(', ', $product->metals) }}</td></tr>
                                                @endif
                                                @if(!empty($product->stone_colors))
                                                    <tr><td class="h6">Colour</td><td class="h6">{{ implode(', ', $product->stone_colors) }}</td></tr>
                                                @endif
                                                @if(!empty($product->sizes))
                                                    <tr><td class="h6">Size</td><td class="h6">{{ implode(', ', $product->sizes) }}</td></tr>
                                                @endif
                                                <tr><td class="h6">Availability</td><td class="h6">{{ $product->stock > 0 ? 'In stock' : 'Sold out' }}</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="widget-accordion-2 style-3">
                                <div class="accordion-title collapsed" data-bs-target="#pd-shipping" data-bs-toggle="collapse"
                                     aria-expanded="false" aria-controls="pd-shipping" role="button">
                                    <span>shipping</span>
                                    <span class="icon ic-accordion-custom"></span>
                                </div>
                                <div id="pd-shipping" class="collapse widget-shipping">
                                    <div class="accordion-body">
                                        <h6 class="fw-normal text-main-4">
                                            Pay by cash on delivery. Shipping is PKR {{ number_format(config('store.shipping_fee')) }}@if($freeOver), free on orders over PKR {{ number_format($freeOver) }}@endif.
                                            @if(config('store.delivery_estimate'))
                                                <br>Estimated delivery: <span class="fw-medium text-main">{{ config('store.delivery_estimate') }}</span>.
                                            @endif
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Product Detail -->

@if($related->isNotEmpty())
<!-- You may also like -->
<section class="flat-spacing-3 pt-0">
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
                                            @if($item->needsOptions())
                                                <a href="{{ route('product', $item->slug) }}" class="hover-tooltip tooltip-left box-icon">
                                                    <span class="icon icon-shop-cart"></span>
                                                    <span class="tooltip">Choose options</span>
                                                </a>
                                            @else
                                                <form method="POST" action="{{ route('cart.add', $item) }}" data-ajax-cart>
                                                    @csrf
                                                    <button type="submit" class="hover-tooltip tooltip-left box-icon" style="border:0;">
                                                        <span class="icon icon-shop-cart"></span>
                                                        <span class="tooltip">Add to Cart</span>
                                                    </button>
                                                </form>
                                            @endif
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
@endsection