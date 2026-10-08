@extends('layouts.app')

@section('content')
@php 
    $hero = $products->first(); 
@endphp



<!-- Hero Banner (DYNAMIC HERO) -->
<div class="hero-banner ctn-hover">
    <div class="container">
        <div class="hero-main">
            {{-- Dynamically load the $hero image into the primary spot --}}
            <div class="img_item item-1 hover-repel">
                @if($hero && $hero->getFirstMediaUrl('gallery'))
                    <img src="{{ $hero->getFirstMediaUrl('gallery', 'large') }}" data-src="{{ $hero->getFirstMediaUrl('gallery', 'large') }}" alt="{{ $hero->name }}" class="lazyload wow fadeInLeft" style="object-fit: cover; height: 100%;">
                @else
                    <img src="images/section/img-item-1.jpg" data-src="images/section/img-item-1.jpg" alt="Trending" class="lazyload wow fadeInLeft">
                @endif
            </div>
            
            {{-- Keep template secondary images --}}
            <div class="img_item item-2 hover-repel d-none d-lg-block">
                <img src="images/section/img-item-2.jpg" data-src="images/section/img-item-2.jpg" alt="Trending" class="lazyload wow fadeInLeftBottom">
            </div>
            <div class="img_item item-3 hover-repel d-none d-lg-block">
                <img src="images/section/img-item-3.jpg" data-src="images/section/img-item-3.jpg" alt="Trending" class="lazyload wow fadeInRightBottom">
            </div>
            <div class="img_item item-4 hover-repel">
                <img src="images/section/img-item-4.jpg" data-src="images/section/img-item-4.jpg" alt="Trending" class="lazyload wow fadeInRight">
            </div>

            <div class="hero-content">
                <h6 class="tag">MOTI ATELIER</h6>
                <p class="title text-hero font-2">
                    HANDMADE <br> <span class="fst-italic">Desi</span> JEWELLERY
                </p>
                <div class="btn-group mt-4">
                    <a href="#collections" class="tf-btn text-uppercase type-large">
                        Shop Now
                        <i class="icon-arrow-right-3 fs-24"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Hero Banner -->

<!-- Banner Text (STORY SECTION) -->
<section class="flat-spacing-3 pt-0 mt-5">
    <div class="container">
        <div class="banner_text flex-sm-nowrap">
            <h3 data-reveal class="text-color-change fw-normal text-sm-start mb-0" style="perspective: 1200px;">
                Every bead is chosen and threaded by hand, <br class="d-none d-xl-block">
                one piece at a time.
            </h3>
        </div>
    </div>
</section>
<!-- /Banner Text -->

<!-- Slider Product (NEW ARRIVALS / $products loop) -->
<section class="flat-spacing-3 bg-main-2 overflow-hidden">
    <div class="container-layout-right-4">
        <div class="slide_wrap">
            <div class="title-left">
                <h2 class="title text-white font-2 fw-normal text-xl-end">
                    <span class="fst-italic">New Arrivals</span>
                </h2>
            </div>
            <div class="wrap">
                <div class="swiper tf-swiper" data-preview="3.39" data-tablet="2.5" data-mobile-sm="2.2" data-mobile="1.4" data-space="10"
                    data-pagination="1" data-pagination-sm="1" data-pagination-md="2" data-pagination-lg="3">
                    <div class="swiper-wrapper">

                        @foreach($products as $product)
                        <div class="swiper-slide">
                            <div class="card_product--V01 type-space-30">
                                <div class="card_product-wrapper aspect-ratio-1">
                                    <a href="{{ route('product', $product->slug) }}" class="product-img">
                                        @if($product->getFirstMediaUrl('gallery'))
                                            <img src="{{ $product->getFirstMediaUrl('gallery', 'card') }}" data-src="{{ $product->getFirstMediaUrl('gallery', 'card') }}" alt="{{ $product->name }}" class="lazyload img-product">
                                            <img src="{{ $product->getFirstMediaUrl('gallery', 'large') }}" data-src="{{ $product->getFirstMediaUrl('gallery', 'large') }}" alt="{{ $product->name }}" class="lazyload img-hover">
                                        @else
                                            <img src="{{ asset('images/products/product-6.jpg') }}" data-src="{{ asset('images/products/product-6.jpg') }}" alt="{{ $product->name }}" class="lazyload img-product">
                                        @endif
                                    </a>
                                    <ul class="list-product-btn">
                                        @if($product->stock > 0)
                                        <li>
                                            <form data-ajax-cart method="POST" action="{{ route('cart.add', $product) }}">
                                                @csrf
                                                <button type="submit" class="hover-tooltip tooltip-left box-icon" style="border:0;">
                                                    <span class="icon icon-shop-cart"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        <li>
                                            <a href="#quickView" data-bs-toggle="modal" class="hover-tooltip tooltip-left box-icon quickview">
                                                <span class="icon icon-view"></span>
                                                <span class="tooltip">Quick View</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card_product-info">
                                    <a href="{{ route('product', $product->slug) }}" class="name-product h5 text-white fw-normal link text-line-clamp-2">
                                        {{ $product->name }}
                                    </a>
                                    <div class="price-wrap text-white mt-1">
                                        @if($product->stock > 0)
                                            <span class="price h6 fw-normal">PKR {{ number_format($product->price) }}</span>
                                            @if($product->compare_at_price)
                                                <span class="text-decoration-line-through opacity-50 ms-2">PKR {{ number_format($product->compare_at_price) }}</span>
                                            @endif
                                        @else
                                            <span class="opacity-75">Sold out</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <div class="sw-dot-default style-white tf-sw-pagination d-lg-none"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Slider Product -->

<!-- Collection -->
<div class="flat-spacing-12">
    <div class="container-full-2">
        
        <h2 data-reveal class="s-title font-2 text-center text-capitalize wow fadeInUp mb-5"><span class="fst-italic">Featured</span> Collections </h2>

        <div dir="ltr" class="swiper tf-swiper" data-preview="4" data-tablet="3" data-mobile-sm="2" data-mobile="1" data-space-lg="10"
            data-space-md="10" data-space="10" data-pagination="1" data-pagination-sm="2" data-pagination-md="3" data-pagination-lg="4">
            <div class="swiper-wrapper">
                
                @foreach($collections as $index => $c)
                    @php 
                        $cover = $c->products->first(); 
                        // Calculate staggered animation delay (0s, 0.1s, 0.2s, etc.)
                        $delay = $index > 0 ? ($index * 0.1) . 's' : '';
                    @endphp
                    
                    <div class="swiper-slide">
                        <a href="{{ route('collection', $c->slug) }}" class="wg-cls hover-img wow fadeInUp" {!! $delay ? 'data-wow-delay="'.$delay.'"' : '' !!}>
                            <div class="image img-style">
                                @if($c->coverUrl('card'))
                                    <img src="{{ $c->coverUrl('card') }}" alt="{{ $c->name }}">
                                @endif
                            </div>
                            <h3 class="name link">
                                {{ strtoupper($c->name) }} 
                                <span class="count text-caption">{{ sprintf('%02d', $c->products->count() ?? 0) }}</span>
                            </h3>
                        </a>
                    </div>
                @endforeach
                
            </div>
            <div class="sw-dot-default tf-sw-pagination"></div>
        </div>
    </div>
</div>
<!-- /Collection -->

<!-- Marquee -->
<div class="bg-dark-black">
    <div class="tf_marquee-V01 style_2 infiniteSlide" data-speed="100">
        <!-- item 1 -->
        <p>Black Friday Sale</p>
        <i class="icon-rhombus"></i>
        <p class="text-clip style-white">New Season Essential</p>
        <i class="icon-diamond"></i>
        <!-- item 2 -->
        <p>Black Friday Sale</p>
        <i class="icon-diamond"></i>
        <p class="text-clip style-white">New Season Essential</p>
        <i class="icon-diamond"></i>
        <!-- item 3 -->
        <p>Black Friday Sale</p>
        <i class="icon-diamond"></i>
        <p class="text-clip style-white">New Season Essential</p>
        <i class="icon-diamond"></i>
        <!-- item 4 -->
        <p>Black Friday Sale</p>
        <i class="icon-diamond"></i>
        <p class="text-clip style-white">New Season Essential</p>
        <i class="icon-diamond"></i>
    </div>
</div>
<!-- /Marqee -->

 <!-- Banner Image Text -->
<div class="flat-spacing-3">
    <div class="container-full-2">
        <div class="banner_V06">
            <div class="bn-image mb-md-0">
                <img src="images/banner/banner-9.jpg" data-src="images/banner/banner-9.jpg" alt="" class="lazyload">
            </div>
            <div class="bn-content">
                <div class="container">
                    <div class="col-md-5 offset-md-7">
                        <div class="wrap wow fadeInUp">
                            <h6 class="caption fw-normal">SUMMER SALE</h6>
                            <p class="title text-hero-2 font-2">Radiate Elegance, <br class="d-none d-xl-block"> <span class="fst-italic">Wear
                                    Confidence</span>
                            </p>
                            <p class="sub-title">Discover exquisitely crafted jewelry designed to complement your style. From timeless
                                classics to modern
                                statement pieces, find the perfect sparkle for every occasion.</p>
                            <a href="shop-collection-list.html" class="tf-btn btn-fill animate-btn type-large text-uppercase">
                                Shop Collection
                                <i class="icon-arrow-right-2 fs-24"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Banner Image Text -->

<!-- Icon Box -->
<div class="flat-spacing-9">
    <div class="container">
        <div dir="ltr" class="swiper tf-swiper" data-preview="4" data-tablet="3" data-mobile-sm="2" data-mobile="1" data-space-lg="48"
            data-space-md="30" data-space="15" data-pagination="1" data-pagination-sm="2" data-pagination-md="3" data-pagination-lg="4">
            <div class="swiper-wrapper">
                <!-- item 1 -->
                <div class="swiper-slide">
                    <div class="box_icon--V02 style_2 wow fadeInLeft">
                        <span class="icon">
                            <i class="icon-box"></i>
                        </span>
                        <div class="content">
                            <h5 class="title">FREE SHIPPING</h5>
                            <p class="text">Enjoy free shipping on all orders</p>
                        </div>
                    </div>
                </div>
                <!-- item 2 -->
                <div class="swiper-slide">
                    <div class="box_icon--V02 style_2 wow fadeInLeft" data-wow-delay="0.1s">
                        <span class="icon">
                            <i class="icon-credit-card"></i>
                        </span>
                        <div class="content">
                            <h5 class="title">SECURED PAYMENT</h5>
                            <p class="text">Secured payment</p>
                        </div>
                    </div>
                </div>
                <!-- item 3 -->
                <div class="swiper-slide">
                    <div class="box_icon--V02 style_2 wow fadeInLeft" data-wow-delay="0.2s">
                        <span class="icon">
                            <i class="icon-return"></i>
                        </span>
                        <div class="content">
                            <h5 class="title">14 DAYS RETURN</h5>
                            <p class="text">Free return in 14 days</p>
                        </div>
                    </div>
                </div>
                <!-- item 4 -->
                <div class="swiper-slide">
                    <div class="box_icon--V02 style_2 wow fadeInLeft" data-wow-delay="0.3s">
                        <span class="icon">
                            <i class="icon-headphone"></i>
                        </span>
                        <div class="content">
                            <h5 class="title">PREMIUM SUPPORT</h5>
                            <p class="text">Enjoy our support 24/7</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sw-dot-default tf-sw-pagination"></div>
        </div>
    </div>
</div>
<!-- /Icon Box -->

<!-- Testimonial -->
<section class="themesFlat">
    <div class="flat-spacing-7 parallaxie" style='background-image: url("images/section/bg-3.jpg");'>
        <div class="container">
            <div class="sect-top wow fadeInUp">
                <h2 class="s-title font-2 text-white text-capitalize">
                    Customer <span class="fst-italic">Reviews</span>
                </h2>
                <div class="group-btn-slider style-white">
                    <div class="nav-prev-swiper tf-sw-nav">
                        <i class="icon-arrow-left"></i>
                    </div>
                    <div class="nav-next-swiper tf-sw-nav">
                        <i class="icon-arrow-right"></i>
                    </div>
                </div>
            </div>
            <div class="swiper tf-swiper" data-preview="4" data-tablet="3" data-mobile-sm="2" data-mobile="1" data-space-lg="30"
                data-space-md="20" data-space="15" data-pagination="1" data-pagination-sm="2" data-pagination-md="3" data-pagination-lg="4">
                <div class="swiper-wrapper">
                    <!-- item 1 -->
                    <div class="swiper-slide">
                        <div class="box_testimonial--V02 wow fadeInLeft">
                            <div class="box_testimonial-content">
                                <div class="tes-head">
                                    <ul class="rate-wrap">
                                        <li><i class="icon-star text-star"></i></li>
                                        <li><i class="icon-star text-star"></i></li>
                                        <li><i class="icon-star text-star"></i></li>
                                        <li><i class="icon-star text-star"></i></li>
                                        <li><i class="icon-star text-star"></i></li>
                                    </ul>
                                    <div class="author-info">
                                        <p class="name">Vincent P.</p>
                                        <p class="verify">

                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g>
                                                    <path
                                                        d="M7 14C10.866 14 14 10.866 14 7C14 3.13401 10.866 0 7 0C3.13401 0 0 3.13401 0 7C0 10.866 3.13401 14 7 14Z"
                                                        fill="#48B02C" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.30268 8.96231L10.2357 4.02924C10.306 3.95923 10.4011 3.91992 10.5003 3.91992C10.5995 3.91992 10.6946 3.95923 10.7649 4.02924L11.2444 4.50877C11.3144 4.57902 11.3537 4.67416 11.3537 4.77334C11.3537 4.87251 11.3144 4.96765 11.2444 5.0379L6.30583 9.97097C6.23582 10.0393 6.14186 10.0776 6.04402 10.0776C5.94618 10.0776 5.85222 10.0393 5.78221 9.97097L5.30268 9.49145C5.23267 9.42119 5.19336 9.32606 5.19336 9.22688C5.19336 9.1277 5.23267 9.03256 5.30268 8.96231Z"
                                                        fill="white" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M3.76447 5.95293L6.7684 8.96238C6.83841 9.03263 6.87772 9.12776 6.87772 9.22694C6.87772 9.32612 6.83841 9.42126 6.7684 9.49151L6.29439 9.96553C6.22413 10.0355 6.129 10.0748 6.02982 10.0748C5.93064 10.0748 5.8355 10.0355 5.76525 9.96553L2.7558 6.96159C2.68579 6.89134 2.64648 6.7962 2.64648 6.69702C2.64648 6.59784 2.68579 6.50271 2.7558 6.43246L3.23533 5.95844C3.30558 5.88843 3.40072 5.84912 3.4999 5.84912C3.59908 5.84912 3.69421 5.88292 3.76447 5.95293Z"
                                                        fill="white" />
                                                </g>
                                            </svg>

                                            Verified
                                        </p>
                                    </div>
                                </div>
                                <div class="tes-text">
                                    <h5>LOVE IT!</h5>
                                    <p class="text">Lightweight yet impactful, they’re crafted to elevate your look from day to night —
                                        effortlessly blending simplicity and sophistication</p>
                                </div>
                            </div>
                            <div class="box_testimonial-item">
                                <div class="image-item">
                                    <img src="images/products/product-38.jpg" alt="">
                                </div>
                                <div class="info-item">
                                    <a href="product-default.html" class="link text-caption text-line-clamp-1 fw-medium">Organically Shaped
                                        Heart
                                        Hoop...</a>
                                    <p class="fw-medium">$1,399.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- item 2 -->
                    <div class="swiper-slide">
                        <div class="box_testimonial--V02 wow fadeInLeft" data-wow-delay="0.1s">
                            <div class="box_testimonial-content">
                                <div class="tes-head">
                                    <ul class="rate-wrap">
                                        <li><i class="icon-star text-star"></i></li>
                                        <li><i class="icon-star text-star"></i></li>
                                        <li><i class="icon-star text-star"></i></li>
                                        <li><i class="icon-star text-star"></i></li>
                                        <li><i class="icon-star text-star"></i></li>
                                    </ul>
                                    <div class="author-info">
                                        <p class="name">Mas Shin</p>
                                        <p class="verify">

                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g>
                                                    <path
                                                        d="M7 14C10.866 14 14 10.866 14 7C14 3.13401 10.866 0 7 0C3.13401 0 0 3.13401 0 7C0 10.866 3.13401 14 7 14Z"
                                                        fill="#48B02C" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.30268 8.96231L10.2357 4.02924C10.306 3.95923 10.4011 3.91992 10.5003 3.91992C10.5995 3.91992 10.6946 3.95923 10.7649 4.02924L11.2444 4.50877C11.3144 4.57902 11.3537 4.67416 11.3537 4.77334C11.3537 4.87251 11.3144 4.96765 11.2444 5.0379L6.30583 9.97097C6.23582 10.0393 6.14186 10.0776 6.04402 10.0776C5.94618 10.0776 5.85222 10.0393 5.78221 9.97097L5.30268 9.49145C5.23267 9.42119 5.19336 9.32606 5.19336 9.22688C5.19336 9.1277 5.23267 9.03256 5.30268 8.96231Z"
                                                        fill="white" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M3.76447 5.95293L6.7684 8.96238C6.83841 9.03263 6.87772 9.12776 6.87772 9.22694C6.87772 9.32612 6.83841 9.42126 6.7684 9.49151L6.29439 9.96553C6.22413 10.0355 6.129 10.0748 6.02982 10.0748C5.93064 10.0748 5.8355 10.0355 5.76525 9.96553L2.7558 6.96159C2.68579 6.89134 2.64648 6.7962 2.64648 6.69702C2.64648 6.59784 2.68579 6.50271 2.7558 6.43246L3.23533 5.95844C3.30558 5.88843 3.40072 5.84912 3.4999 5.84912C3.59908 5.84912 3.69421 5.88292 3.76447 5.95293Z"
                                                        fill="white" />
                                                </g>
                                            </svg>

                                            Verified
                                        </p>
                                    </div>
                                </div>
                                <div class="tes-text">
                                    <h5>RECOMMEND!</h5>
                                    <p class="text">
                                        The quality of the jewelry exceeded my expectations. Each piece feels premium and beautifully crafted,
                                        and the designs are incredibly stylish. I’m absolutely obsessed with my new collection!
                                    </p>
                                </div>
                            </div>
                            <div class="box_testimonial-item">
                                <div class="image-item">
                                    <img src="images/products/product-39.jpg" alt="">
                                </div>
                                <div class="info-item">
                                    <a href="product-default.html" class="link text-caption text-line-clamp-1 fw-medium">Hammered Teardrop
                                        Studs...</a>
                                    <p class="fw-medium">$2,499.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- item 3 -->
                    <div class="swiper-slide">
                        <div class="box_testimonial--V02 wow fadeInLeft" data-wow-delay="0.2s">
                            <div class="box_testimonial-content">
                                <div class="tes-head">
                                    <ul class="rate-wrap">
                                        <li><i class="icon-star text-star"></i></li>
                                        <li><i class="icon-star text-star"></i></li>
                                        <li><i class="icon-star text-star"></i></li>
                                        <li><i class="icon-star text-star"></i></li>
                                        <li><i class="icon-star text-star"></i></li>
                                    </ul>
                                    <div class="author-info">
                                        <p class="name">Rose Vo</p>
                                        <p class="verify">

                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g>
                                                    <path
                                                        d="M7 14C10.866 14 14 10.866 14 7C14 3.13401 10.866 0 7 0C3.13401 0 0 3.13401 0 7C0 10.866 3.13401 14 7 14Z"
                                                        fill="#48B02C" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.30268 8.96231L10.2357 4.02924C10.306 3.95923 10.4011 3.91992 10.5003 3.91992C10.5995 3.91992 10.6946 3.95923 10.7649 4.02924L11.2444 4.50877C11.3144 4.57902 11.3537 4.67416 11.3537 4.77334C11.3537 4.87251 11.3144 4.96765 11.2444 5.0379L6.30583 9.97097C6.23582 10.0393 6.14186 10.0776 6.04402 10.0776C5.94618 10.0776 5.85222 10.0393 5.78221 9.97097L5.30268 9.49145C5.23267 9.42119 5.19336 9.32606 5.19336 9.22688C5.19336 9.1277 5.23267 9.03256 5.30268 8.96231Z"
                                                        fill="white" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M3.76447 5.95293L6.7684 8.96238C6.83841 9.03263 6.87772 9.12776 6.87772 9.22694C6.87772 9.32612 6.83841 9.42126 6.7684 9.49151L6.29439 9.96553C6.22413 10.0355 6.129 10.0748 6.02982 10.0748C5.93064 10.0748 5.8355 10.0355 5.76525 9.96553L2.7558 6.96159C2.68579 6.89134 2.64648 6.7962 2.64648 6.69702C2.64648 6.59784 2.68579 6.50271 2.7558 6.43246L3.23533 5.95844C3.30558 5.88843 3.40072 5.84912 3.4999 5.84912C3.59908 5.84912 3.69421 5.88292 3.76447 5.95293Z"
                                                        fill="white" />
                                                </g>
                                            </svg>

                                            Verified
                                        </p>
                                    </div>
                                </div>
                                <div class="tes-text">
                                    <h5>RECOMMEND!</h5>
                                    <p class="text">
                                        I was blown away by the craftsmanship of these jewelry pieces. Every item feels luxurious and the
                                        modern designs are simply stunning
                                    </p>
                                </div>
                            </div>
                            <div class="box_testimonial-item">
                                <div class="image-item">
                                    <img src="images/products/product-37.jpg" alt="">
                                </div>
                                <div class="info-item">
                                    <a href="product-default.html" class="link text-caption text-line-clamp-1 fw-medium">Sculpted Pearl Drop
                                        Earrings</a>
                                    <p class="fw-medium">$2,799.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- item 4 -->
                    <div class="swiper-slide">
                        <div class="box_testimonial--V02 wow fadeInLeft" data-wow-delay="0.3s">
                            <div class="box_testimonial-content">
                                <div class="tes-head">
                                    <ul class="rate-wrap">
                                        <li><i class="icon-star text-star"></i></li>
                                        <li><i class="icon-star text-star"></i></li>
                                        <li><i class="icon-star text-star"></i></li>
                                        <li><i class="icon-star text-star"></i></li>
                                        <li><i class="icon-star text-star"></i></li>
                                    </ul>
                                    <div class="author-info">
                                        <p class="name">David Ngo</p>
                                        <p class="verify">

                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g>
                                                    <path
                                                        d="M7 14C10.866 14 14 10.866 14 7C14 3.13401 10.866 0 7 0C3.13401 0 0 3.13401 0 7C0 10.866 3.13401 14 7 14Z"
                                                        fill="#48B02C" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.30268 8.96231L10.2357 4.02924C10.306 3.95923 10.4011 3.91992 10.5003 3.91992C10.5995 3.91992 10.6946 3.95923 10.7649 4.02924L11.2444 4.50877C11.3144 4.57902 11.3537 4.67416 11.3537 4.77334C11.3537 4.87251 11.3144 4.96765 11.2444 5.0379L6.30583 9.97097C6.23582 10.0393 6.14186 10.0776 6.04402 10.0776C5.94618 10.0776 5.85222 10.0393 5.78221 9.97097L5.30268 9.49145C5.23267 9.42119 5.19336 9.32606 5.19336 9.22688C5.19336 9.1277 5.23267 9.03256 5.30268 8.96231Z"
                                                        fill="white" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M3.76447 5.95293L6.7684 8.96238C6.83841 9.03263 6.87772 9.12776 6.87772 9.22694C6.87772 9.32612 6.83841 9.42126 6.7684 9.49151L6.29439 9.96553C6.22413 10.0355 6.129 10.0748 6.02982 10.0748C5.93064 10.0748 5.8355 10.0355 5.76525 9.96553L2.7558 6.96159C2.68579 6.89134 2.64648 6.7962 2.64648 6.69702C2.64648 6.59784 2.68579 6.50271 2.7558 6.43246L3.23533 5.95844C3.30558 5.88843 3.40072 5.84912 3.4999 5.84912C3.59908 5.84912 3.69421 5.88292 3.76447 5.95293Z"
                                                        fill="white" />
                                                </g>
                                            </svg>

                                            Verified
                                        </p>
                                    </div>
                                </div>
                                <div class="tes-text">
                                    <h5>LOVE IT!</h5>
                                    <p class="text">
                                        These minimalist hoops add the perfect touch of elegance to any outfit. Designed for everyday wear
                                        with a sleek, modern finish
                                    </p>
                                </div>
                            </div>
                            <div class="box_testimonial-item">
                                <div class="image-item">
                                    <img src="images/products/product-36.jpg" alt="">
                                </div>
                                <div class="info-item">
                                    <a href="product-default.html" class="link text-caption text-line-clamp-1 fw-medium">Brushed Metal Cuff
                                        Bracelet</a>
                                    <p class="fw-medium">$4,399.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- item 5 -->
                    <div class="swiper-slide">
                        <div class="box_testimonial--V02">
                            <div class="box_testimonial-content">
                                <div class="tes-head">
                                    <ul class="rate-wrap">
                                        <li><i class="icon-star text-star"></i></li>
                                        <li><i class="icon-star text-star"></i></li>
                                        <li><i class="icon-star text-star"></i></li>
                                        <li><i class="icon-star text-star"></i></li>
                                        <li><i class="icon-star text-star"></i></li>
                                    </ul>
                                    <div class="author-info">
                                        <p class="name">Vincent P.</p>
                                        <p class="verify">

                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g>
                                                    <path
                                                        d="M7 14C10.866 14 14 10.866 14 7C14 3.13401 10.866 0 7 0C3.13401 0 0 3.13401 0 7C0 10.866 3.13401 14 7 14Z"
                                                        fill="#48B02C" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.30268 8.96231L10.2357 4.02924C10.306 3.95923 10.4011 3.91992 10.5003 3.91992C10.5995 3.91992 10.6946 3.95923 10.7649 4.02924L11.2444 4.50877C11.3144 4.57902 11.3537 4.67416 11.3537 4.77334C11.3537 4.87251 11.3144 4.96765 11.2444 5.0379L6.30583 9.97097C6.23582 10.0393 6.14186 10.0776 6.04402 10.0776C5.94618 10.0776 5.85222 10.0393 5.78221 9.97097L5.30268 9.49145C5.23267 9.42119 5.19336 9.32606 5.19336 9.22688C5.19336 9.1277 5.23267 9.03256 5.30268 8.96231Z"
                                                        fill="white" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M3.76447 5.95293L6.7684 8.96238C6.83841 9.03263 6.87772 9.12776 6.87772 9.22694C6.87772 9.32612 6.83841 9.42126 6.7684 9.49151L6.29439 9.96553C6.22413 10.0355 6.129 10.0748 6.02982 10.0748C5.93064 10.0748 5.8355 10.0355 5.76525 9.96553L2.7558 6.96159C2.68579 6.89134 2.64648 6.7962 2.64648 6.69702C2.64648 6.59784 2.68579 6.50271 2.7558 6.43246L3.23533 5.95844C3.30558 5.88843 3.40072 5.84912 3.4999 5.84912C3.59908 5.84912 3.69421 5.88292 3.76447 5.95293Z"
                                                        fill="white" />
                                                </g>
                                            </svg>

                                            Verified
                                        </p>
                                    </div>
                                </div>
                                <div class="tes-text">
                                    <h5>LOVE IT!</h5>
                                    <p class="text">The quality of the clothes exceeded my expectations. Every piece feels
                                        premium, and the
                                        designs are so trendy.</p>
                                </div>
                            </div>
                            <div class="box_testimonial-item">
                                <div class="image-item">
                                    <img src="images/products/product-38.jpg" alt="">
                                </div>
                                <div class="info-item">
                                    <a href="product-default.html" class="link text-caption text-line-clamp-1 fw-medium">Organically Shaped
                                        Heart
                                        Hoop...</a>
                                    <p class="fw-medium">$1,599.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sw-dot-default style-white tf-sw-pagination"></div>
            </div>
        </div>
    </div>
</section>
<!-- /Testimonial -->



<!-- ALL TEMPLATE MODALS GO HERE -->
    <!-- Auto Newsletter -->
    <!-- <div class="modal modalCentered fade auto-popup modal-auto-newletter" id="autoNewletter">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <span class="icon-close-popup" data-bs-dismiss="modal">
                    <i class="icon-close"></i>
                </span>
                <div class="modal-body">
                    <div class="image">
                        <img src="images/banner/banner-newletter.jpg" alt="">
                    </div>
                    <div class="content text-center">
                        <div class="heading">
                            <h2 class="title text-uppercase">Get 15% OFF</h2>
                            <p class="sub-title">SUBSCRIBE TO OUR NEWSLETTER & RECEIVE A COUPON</p>
                        </div>
                        <div class="sib-form">
                            <div id="sib-form-container" class="sib-form-container">
                                <div id="error-message" class="sib-form-message-panel">
                                    <div class="sib-form-message-panel__text sib-form-message-panel__text--center">
                                        <span class="sib-form-message-panel__inner-text">Your subscription could not be saved. Please try again.
                                        </span>
                                    </div>
                                </div>
                                <div id="success-message" class="sib-form-message-panel">
                                    <div class="sib-form-message-panel__text sib-form-message-panel__text--center">
                                        <span class="sib-form-message-panel__inner-text">Your subscription has been successful.
                                        </span>
                                    </div>
                                </div>
                                <div id="sib-container" class="sib-container--large sib-container--vertical">
                                    <form id="sib-form" method="POST" class="form-newsletter"
                                        action="https://3c02c1a1.sibforms.com/serve/MUIFAOAhSCDRnPhdPWLTpLBkaFR0CvSbJ_okYrjCbXQRLkZZU67Hn2jdn18hTWJuGupI4VUfB4deuJIyP5yRoHWVb9pIrENAMcal9Jtz8q_qN4dpHNMIG454DwSVNVmnLXuePoOCvDqN_Vvs0ga_kzg7ouD63HjCaukRz3LGCQsfnQJBN4-KS2D3DVitqvFsDHSqevjjqLk2xFO4"
                                        data-type="subscription">
                                        <div>
                                            <div class="sib-form-block">
                                                <p></p>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="sib-form-block">
                                                <div class="sib-text-form-block">
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="sib-input sib-form-block">
                                                <div class="form__entry entry_block">
                                                    <div class="form__label-row ">
                                                        <label class="entry__label" for="EMAIL"></label>
                                                        <div class="entry__field">
                                                            <input class="input" type="text" id="EMAIL" name="EMAIL" autocomplete="off"
                                                                placeholder="ENTER YOUR EMAIL WHERE WE SEND YOU 15% OFF" data-required="true"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <label class="entry__error entry__error--primary text-center"></label>
                                                    <label class="entry__specification"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="sib-optin sib-form-block">
                                                <div class="form__entry entry_mcq">
                                                    <div class="form__label-row ">
                                                        <div class="entry__choice">
                                                            <label>
                                                                <input type="checkbox" class="input_replaced" value="1" id="OPT_IN" name="OPT_IN" />
                                                                <span class="checkbox checkbox_tick_positive"></span>
                                                                <span>
                                                                    <p></p>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <label class="entry__error entry__error--primary"></label>
                                                    <label class="entry__specification"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <div class="sib-form-block">
                                                <button
                                                    class="sib-form-block__button sib-form-block__button-with-loader subscribe-button tf-btn btn-fill animate-btn w-100 font-main"
                                                    form="sib-form" type="submit">
                                                    <svg class="icon clickable__icon progress-indicator__icon sib-hide-loader-icon"
                                                        viewBox="0 0 512 512">
                                                        <path
                                                            d="M460.116 373.846l-20.823-12.022c-5.541-3.199-7.54-10.159-4.663-15.874 30.137-59.886 28.343-131.652-5.386-189.946-33.641-58.394-94.896-95.833-161.827-99.676C261.028 55.961 256 50.751 256 44.352V20.309c0-6.904 5.808-12.337 12.703-11.982 83.556 4.306 160.163 50.864 202.11 123.677 42.063 72.696 44.079 162.316 6.031 236.832-3.14 6.148-10.75 8.461-16.728 5.01z">
                                                        </path>
                                                    </svg>
                                                    <span class="fw-medium">GET IT NOW!</span>
                                                </button>
                                                <button
                                                    class="sib-form-block__button sib-form-block__button-with-loader btn-style-2 radius-12 w-100 justify-content-center"
                                                    form="sib-form" type="submit">
                                                    <svg class="icon clickable__icon progress-indicator__icon sib-hide-loader-icon"
                                                        viewBox="0 0 512 512">
                                                        <path
                                                            d="M460.116 373.846l-20.823-12.022c-5.541-3.199-7.54-10.159-4.663-15.874 30.137-59.886 28.343-131.652-5.386-189.946-33.641-58.394-94.896-95.833-161.827-99.676C261.028 55.961 256 50.751 256 44.352V20.309c0-6.904 5.808-12.337 12.703-11.982 83.556 4.306 160.163 50.864 202.11 123.677 42.063 72.696 44.079 162.316 6.031 236.832-3.14 6.148-10.75 8.461-16.728 5.01z">
                                                        </path>
                                                    </svg>
                                                    <span class="text text-btn-uppercase">SUBSCRIBE</span>
                                                </button>
                                            </div>
                                            <a href="#" data-bs-dismiss="modal" class="tf-btn w-100 border-0 close-modal">
                                                <span class="fw-medium">NO THANKS!</span>
                                            </a>
                                        </div>
                                        <input type="text" name="email_address_check" value="" class="input--hidden">
                                        <input type="hidden" name="locale" value="en">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <p class="privacy text-main-6">
                            Will be used in accordance with our
                            <a href="privacy.html" class="tf-btn-line style-line-2 text-main link">
                                <span class="text-body">Privacy Policy</span>
                            </a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- /Auto Newsletter -->

    <div class="modal modalCentered fade modal-log" id="log">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-top">
                    <span class="icon-close-popup" data-bs-dismiss="modal">
                        <i class="icon-close"></i>
                    </span>
                    <h3 class="title fw-normal text-uppercase">login</h3>
                </div>
                <div class="modal-bottom">
                    <form class="form-log">
                        <div class="form-content">
                            <fieldset class="tf-field">
                                <input class="tf-input" type="text" placeholder value="Hello@vemus.com" required>
                                <label class="tf-lable">Username *</label>
                            </fieldset>
                            <fieldset class="tf-field password-wrapper">
                                <input class="tf-input password-field" type="password" placeholder required>
                                <label class="tf-lable">Password *</label>
                                <span class=" toggle-pass icon-show-password"></span>
                            </fieldset>
                        </div>
                        <div class="bottom">
                            <div class="checkbox-wrap">
                                <input id="remember" type="checkbox" class="tf-check">
                                <label for="remember">Remember me</label>
                            </div>
                            <a href="#reset" data-bs-toggle="offcanvas" class="link">
                                Forgot password?
                            </a>
                        </div>
                        <button type="submit" class="btn-submit tf-btn btn-fill-2 w-100">
                            LOG IN
                        </button>
                    </form>
                    <div class="other-login">
                        <a href="#" class="tf-btn btn-fill-3 ic-abs w-100 fw-medium">
                            <span class="icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="12" fill="#3B5998" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M15.1163 7.992L13.9867 7.99275C13.101 7.99275 12.9293 8.4135 12.9293 9.03075V10.3927H15.042L14.7667 12.5265H12.9293V18H10.7265V12.5265H8.8845V10.3927H10.7265V8.82C10.7265 6.99375 11.8417 6 13.47 6C14.25 6 14.9205 6.05775 15.1163 6.084V7.992ZM12 0C5.373 0 0 5.37225 0 12C0 18.627 5.373 24 12 24C18.6278 24 24 18.627 24 12C24 5.37225 18.6278 0 12 0Z"
                                        fill="white" />
                                </svg>
                            </span>
                            Log in with Facebook
                        </a>
                        <a href="#" class="tf-btn style-2 ic-abs w-100 fw-medium">
                            <span class="icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path
                                            d="M23.0938 9.91258L13.3045 9.91211C12.8722 9.91211 12.5218 10.2625 12.5218 10.6947V13.822C12.5218 14.2542 12.8722 14.6046 13.3044 14.6046H18.8172C18.2135 16.1712 17.0869 17.4832 15.6494 18.3168L18 22.386C21.7707 20.2052 24 16.3789 24 12.0955C24 11.4857 23.9551 11.0497 23.8652 10.5587C23.7968 10.1858 23.473 9.91258 23.0938 9.91258Z"
                                            fill="#167EE6" />
                                        <path
                                            d="M12 19.3037C9.30218 19.3037 6.94699 17.8297 5.68207 15.6484L1.61304 17.9938C3.68374 21.5826 7.56283 23.9994 12 23.9994C14.1768 23.9994 16.2307 23.4133 18 22.3919V22.3863L15.6494 18.3171C14.5742 18.9408 13.3299 19.3037 12 19.3037Z"
                                            fill="#12B347" />
                                        <path
                                            d="M18 22.3932V22.3876L15.6494 18.3184C14.5741 18.9419 13.33 19.3049 12 19.3049V24.0006C14.1767 24.0006 16.2308 23.4145 18 22.3932Z"
                                            fill="#0F993E" />
                                        <path
                                            d="M4.69566 12.0003C4.69566 10.6705 5.05856 9.42637 5.68205 8.3512L1.61302 6.00586C0.586031 7.76962 0 9.81797 0 12.0003C0 14.1826 0.586031 16.2309 1.61302 17.9947L5.68205 15.6494C5.05856 14.5742 4.69566 13.3301 4.69566 12.0003Z"
                                            fill="#FFD500" />
                                        <path
                                            d="M12 4.69566C13.7593 4.69566 15.3753 5.32078 16.6375 6.36061C16.9489 6.61711 17.4014 6.59859 17.6867 6.31336L19.9024 4.09758C20.2261 3.77395 20.203 3.24422 19.8573 2.94431C17.7425 1.10967 14.991 0 12 0C7.56283 0 3.68374 2.41673 1.61304 6.00558L5.68207 8.35092C6.94699 6.16969 9.30218 4.69566 12 4.69566Z"
                                            fill="#FF4B26" />
                                        <path
                                            d="M16.6374 6.36061C16.9488 6.61711 17.4015 6.59859 17.6866 6.31336L19.9024 4.09758C20.226 3.77395 20.2029 3.24422 19.8573 2.94431C17.7425 1.10962 14.991 0 12 0V4.69566C13.7592 4.69566 15.3752 5.32078 16.6374 6.36061Z"
                                            fill="#D93F21" />
                                    </g>
                                </svg>
                            </span>
                            Log in with Google
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="#register" data-bs-toggle="modal" class="tf-btn-line">
                            <span class="text-body">
                                New customer? Create your account
                            </span>
                            <i class="icon-arrow-top-right"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- /Login -->
    <!-- Register -->
    <div class="modal modalCentered fade modal-log" id="register">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-top">
                    <span class="icon-close-popup" data-bs-dismiss="modal">
                        <i class="icon-close"></i>
                    </span>
                    <h3 class="title fw-normal text-uppercase">create account</h3>
                </div>
                <div class="modal-bottom">
                    <form class="form-log">
                        <div class="form-content">
                            <fieldset class="tf-field">
                                <input class="tf-input" type="text" placeholder required>
                                <label class="tf-lable">First name *</label>
                            </fieldset>
                            <fieldset class="tf-field">
                                <input class="tf-input" type="text" placeholder required>
                                <label class="tf-lable">Last name *</label>
                            </fieldset>
                            <fieldset class="tf-field">
                                <input class="tf-input" type="email" placeholder value="Hello@vemus.com" required>
                                <label class="tf-lable">Email *</label>
                            </fieldset>
                            <fieldset class="tf-field password-wrapper">
                                <input class="tf-input password-field" type="password" placeholder required>
                                <label class="tf-lable">Password *</label>
                                <span class=" toggle-pass icon-show-password"></span>
                            </fieldset>
                        </div>
                        <div class="bottom">
                            <div class="checkbox-wrap align-items-start">
                                <input id="confirm" type="checkbox" class="tf-check flex-shrink-0">
                                <label for="confirm" class="text-caption">
                                    Yes, sign me up for the Vemus Newsletter. I confirm I am over 16 years old. I would
                                    like to receive digital
                                    communications (email and SMS) from Vemus about Vemus products and exclusive offers.
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn-submit tf-btn btn-fill-2 w-100">
                            LOG IN
                        </button>
                    </form>
                    <div class="other-login">
                        <a href="#" class="tf-btn btn-fill-3 ic-abs w-100 fw-medium">
                            <span class="icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="12" fill="#3B5998" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M15.1163 7.992L13.9867 7.99275C13.101 7.99275 12.9293 8.4135 12.9293 9.03075V10.3927H15.042L14.7667 12.5265H12.9293V18H10.7265V12.5265H8.8845V10.3927H10.7265V8.82C10.7265 6.99375 11.8417 6 13.47 6C14.25 6 14.9205 6.05775 15.1163 6.084V7.992ZM12 0C5.373 0 0 5.37225 0 12C0 18.627 5.373 24 12 24C18.6278 24 24 18.627 24 12C24 5.37225 18.6278 0 12 0Z"
                                        fill="white" />
                                </svg>
                            </span>
                            Log in with Facebook
                        </a>
                        <a href="#" class="tf-btn style-2 ic-abs w-100 fw-medium">
                            <span class="icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path
                                            d="M23.0938 9.91258L13.3045 9.91211C12.8722 9.91211 12.5218 10.2625 12.5218 10.6947V13.822C12.5218 14.2542 12.8722 14.6046 13.3044 14.6046H18.8172C18.2135 16.1712 17.0869 17.4832 15.6494 18.3168L18 22.386C21.7707 20.2052 24 16.3789 24 12.0955C24 11.4857 23.9551 11.0497 23.8652 10.5587C23.7968 10.1858 23.473 9.91258 23.0938 9.91258Z"
                                            fill="#167EE6" />
                                        <path
                                            d="M12 19.3037C9.30218 19.3037 6.94699 17.8297 5.68207 15.6484L1.61304 17.9938C3.68374 21.5826 7.56283 23.9994 12 23.9994C14.1768 23.9994 16.2307 23.4133 18 22.3919V22.3863L15.6494 18.3171C14.5742 18.9408 13.3299 19.3037 12 19.3037Z"
                                            fill="#12B347" />
                                        <path
                                            d="M18 22.3932V22.3876L15.6494 18.3184C14.5741 18.9419 13.33 19.3049 12 19.3049V24.0006C14.1767 24.0006 16.2308 23.4145 18 22.3932Z"
                                            fill="#0F993E" />
                                        <path
                                            d="M4.69566 12.0003C4.69566 10.6705 5.05856 9.42637 5.68205 8.3512L1.61302 6.00586C0.586031 7.76962 0 9.81797 0 12.0003C0 14.1826 0.586031 16.2309 1.61302 17.9947L5.68205 15.6494C5.05856 14.5742 4.69566 13.3301 4.69566 12.0003Z"
                                            fill="#FFD500" />
                                        <path
                                            d="M12 4.69566C13.7593 4.69566 15.3753 5.32078 16.6375 6.36061C16.9489 6.61711 17.4014 6.59859 17.6867 6.31336L19.9024 4.09758C20.2261 3.77395 20.203 3.24422 19.8573 2.94431C17.7425 1.10967 14.991 0 12 0C7.56283 0 3.68374 2.41673 1.61304 6.00558L5.68207 8.35092C6.94699 6.16969 9.30218 4.69566 12 4.69566Z"
                                            fill="#FF4B26" />
                                        <path
                                            d="M16.6374 6.36061C16.9488 6.61711 17.4015 6.59859 17.6866 6.31336L19.9024 4.09758C20.226 3.77395 20.2029 3.24422 19.8573 2.94431C17.7425 1.10962 14.991 0 12 0V4.69566C13.7592 4.69566 15.3752 5.32078 16.6374 6.36061Z"
                                            fill="#D93F21" />
                                    </g>
                                </svg>
                            </span>
                            Log in with Google
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Register -->
    <!-- Reset Password -->
    <div class="offcanvas offcanvas-end canvas-sidebar" id="reset">
        <div class="canvas-header">
            <h3 class="title fw-normal text-uppercase">Reset password</h3>
            <span class="icon-close link icon-close-popup" data-bs-dismiss="offcanvas"></span>
        </div>
        <div class="canvas-body">
            <p class="sub-title text-main-4">Please enter your registered email address to receive an email to reset
                your password</p>
            <form class="form-reset">
                <div class="form-content">
                    <fieldset class="tf-field">
                        <input class="tf-input" type="text" placeholder required>
                        <label class="tf-lable">Email *</label>
                    </fieldset>
                </div>
                <button type="submit" class="tf-btn btn-fill w-100 fw-medium animate-btn">
                    SUBMIT
                </button>
            </form>
        </div>
    </div>
    <!-- /Reset Password -->
   
    
    <!-- Compare -->
    <div class="modal modalCentered fade modal-compare" id="compare">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <span class="icon-close-popup" data-bs-dismiss="modal">
                    <i class="icon-close"></i>
                </span>
                <div class="modal-heading">
                    <h3 class="title fw-normal text-uppercase">compare products</h3>
                </div>
                <div class="modal-body main-list-clear">
                    <div class="tf-compare-inner">
                        <div class="tf-compare-list list-empty">
                            <p class="text-empty">Your compare is curently empty</p>
                            <div class="tf-compare-item card_product--V01 file-delete">
                                <div class="card_product-wrapper aspect-ratio-1">
                                    <span class="remove icon-close"></span>
                                    <a href="product-default.html" class="product-img">
                                        <img src="images/products/product-24.jpg" data-src="images/products/product-24.jpg" alt="Image Product"
                                            class="lazyload img-product">
                                        <img src="images/products/product-25.jpg" data-src="images/products/product-25.jpg" alt="Image Product"
                                            class="lazyload img-hover">
                                    </a>
                                </div>
                                <div class="card_product-info text-center">
                                    <a href="product-default.html" class="name-product link text-line-clamp-2">
                                        Crystal Birthstone Eternity Circle Charm
                                    </a>
                                    <div class="price-wrap justify-content-center">
                                        <span class="price-new fw-medium">$3,370.00</span>
                                        <span class="price-old fw-normal text-caption">$3,899.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="tf-compare-item card_product--V01 file-delete">
                                <div class="card_product-wrapper aspect-ratio-1">
                                    <span class="remove icon-close"></span>
                                    <a href="product-default.html" class="product-img">
                                        <img src="images/products/product-26.jpg" data-src="images/products/product-26.jpg" alt="Image Product"
                                            class="lazyload img-product">
                                        <img src="images/products/product-27.jpg" data-src="images/products/product-27.jpg" alt="Image Product"
                                            class="lazyload img-hover">
                                    </a>
                                </div>
                                <div class="card_product-info text-center">
                                    <a href="product-default.html" class="name-product link text-line-clamp-2">
                                        Ball Bracelet
                                    </a>
                                    <div class="price-wrap justify-content-center">
                                        <span class="price-new fw-medium">$2,499.00</span>
                                        <span class="price-old fw-normal text-caption">$2,899.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="tf-compare-item card_product--V01 file-delete">
                                <div class="card_product-wrapper aspect-ratio-1">
                                    <span class="remove icon-close"></span>
                                    <a href="product-default.html" class="product-img">
                                        <img src="images/products/product-28.jpg" data-src="images/products/product-28.jpg" alt="Image Product"
                                            class="lazyload img-product">
                                        <img src="images/products/product-29.jpg" data-src="images/products/product-29.jpg" alt="Image Product"
                                            class="lazyload img-hover">
                                    </a>
                                </div>
                                <div class="card_product-info text-center">
                                    <a href="product-default.html" class="name-product link text-line-clamp-2">
                                        Engagement Ring in 18k Yellow Gold
                                    </a>
                                    <div class="price-wrap justify-content-center">
                                        <span class="price-new fw-medium">$2,499.00</span>
                                        <span class="price-old fw-normal text-caption">$2,899.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="tf-compare-item card_product--V01 file-delete">
                                <div class="card_product-wrapper aspect-ratio-1">
                                    <span class="remove icon-close"></span>
                                    <a href="product-default.html" class="product-img">
                                        <img src="images/products/product-34.jpg" data-src="images/products/product-34.jpg" alt="Image Product"
                                            class="lazyload img-product">
                                        <img src="images/products/product-35.jpg" data-src="images/products/product-35.jpg" alt="Image Product"
                                            class="lazyload img-hover">
                                    </a>
                                </div>
                                <div class="card_product-info text-center">
                                    <a href="product-default.html" class="name-product link text-line-clamp-2">
                                        Vine Ring in Platinum with a Tanzanite and Diamonds
                                    </a>
                                    <div class="price-wrap justify-content-center">
                                        <span class="price-new fw-medium">$2,499.00</span>
                                        <span class="price-old fw-normal text-caption">$2,899.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="group-btn">
                        <a href="compare.html" class="tf-btn btn-fill animate-btn fw-medium">
                            COMPARE <span class="count-item-compare">(4)</span>
                        </a>
                        <button type="button" class="tf-btn fw-medium clear-list-empty">
                            <span>CLEAR ALL</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Compare -->
    <!-- Size Guide -->
    <div class="offcanvas offcanvas-end canvas-sidebar canvas-size" id="sizeGuide">
        <div class="canvas-header">
            <h3 class="title fw-normal text-uppercase">size guide</h3>
            <span class="icon-close link icon-close-popup" data-bs-dismiss="offcanvas"></span>
        </div>
        <div class="canvas-body">
            <div class="tf-page-size-chart-content">
                <p class="title h5 fw-normal text-uppercase">know the size</p>
                <ul class="resize-info-list">
                    <li>1. Select an existing ring that fits the desired finger.</li>
                    <li>2. Measure the internal diameter of the ring in mm.</li>
                    <li>3. Select the diameter below to determine your ring size.</li>
                </ul>
                <div class="img-chart">
                    <img src="images/section/resize-chart.png" data-src="images/section/resize-chart.png" alt="" class="lazyload">
                </div>
            </div>
            <div class="tf-table-res-df">
                <p class="title h5 fw-normal text-uppercase">Size chart</p>
                <p class="sub text-main-4 mb-0">
                    At Vemus Jewelry, we want your jewelry to fit flawlessly. Use our size guide to ensure the perfect
                    match
                    for rings, bracelets, and necklaces.
                </p>
            </div>
            <div class="tf-sizeguide-table">
                <table>
                    <thead>
                        <tr>
                            <th>INTERNAL DIAMETER (MM)</th>
                            <th>US</th>
                            <th>US</th>
                            <th>EU</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>13.6</td>
                            <td>E</td>
                            <td>2.75</td>
                            <td>42</td>
                        </tr>
                        <tr>
                            <td>14.0</td>
                            <td>F</td>
                            <td>3.25</td>
                            <td>44</td>
                        </tr>
                        <tr>
                            <td>14.4</td>
                            <td>G</td>
                            <td>3.75</td>
                            <td>45</td>
                        </tr>
                        <tr>
                            <td>14.9</td>
                            <td>H</td>
                            <td>4.25</td>
                            <td>46.5</td>
                        </tr>
                        <tr>
                            <td>15.1</td>
                            <td>I</td>
                            <td>4.5</td>
                            <td>47</td>
                        </tr>
                        <tr>
                            <td>15.5</td>
                            <td>J</td>
                            <td>5</td>
                            <td>48.5</td>
                        </tr>
                        <tr>
                            <td>15.9</td>
                            <td>K</td>
                            <td>5.5</td>
                            <td>50</td>
                        </tr>
                        <tr>
                            <td>16.3</td>
                            <td>l</td>
                            <td>6</td>
                            <td>51</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /Size Guide -->

@endsection