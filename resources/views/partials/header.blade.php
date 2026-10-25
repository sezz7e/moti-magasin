@php
    // Transparent header floating over the home page hero. Set to false if your
    // home page doesn't start with a full-width image, or the header will overlap it.
    $overlay = request()->routeIs('home');

    $navCollections = \App\Models\Collection::orderBy('sort_order')->get(['id', 'name', 'slug']);
    $navPicks = \App\Models\Product::with('media')->where('is_active', true)->latest()->take(4)->get();
    $navFeature = $navPicks->first();
    $navFeatureImage = $navFeature?->getFirstMediaUrl('gallery', 'large');
@endphp
<!-- Header -->
<header class="tf-header {{ $overlay ? 'header-absolute-2' : '' }} type-2">
    <div class="container-3">
        <div class="row align-items-center">
            <div class="col-md-4 col-3 d-xl-none">
                <a href="#mobileMenu" data-bs-toggle="offcanvas" class="btn-mobile-menu" aria-label="Open menu">
                    <span></span>
                </a>
            </div>

            <div class="col-xl-5 d-none d-xl-block">
                <nav class="box-navigation">
                    <ul class="box-nav-menu justify-content-start">
                        <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
                            <a href="{{ route('home') }}" class="item-link">Home</a>
                        </li>

                        <li class="menu-item {{ request()->routeIs('shop', 'collection') ? 'active' : '' }}">
                            <a href="{{ route('shop') }}" class="item-link">Shop<i class="icon icon-arrow-angle-down"></i></a>
                            <div class="sub-menu mega-menu container-layout-right mega-menu-shop mega-menu-style-2">
                                <div class="mega-menu-wrap">
                                    <div class="wrapper-sub-menu">
                                        @if($navCollections->isNotEmpty())
                                            <div class="mega-menu-item">
                                                <p class="text-caption menu-heading">COLLECTIONS</p>
                                                <ul class="menu-list">
                                                    @foreach($navCollections as $c)
                                                        <li><a href="{{ route('collection', $c->slug) }}" class="menu-link-text link">{{ $c->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="mega-menu-item">
                                            <p class="text-caption menu-heading">SHOP</p>
                                            <ul class="menu-list">
                                                <li><a href="{{ route('shop') }}" class="menu-link-text link">All jewellery</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    @if($navFeatureImage)
                                        <div class="wrapper-sub-collection">
                                            <div class="box_image--V01 h-100 hover-img">
                                                <div class="image h-100 img-style">
                                                    <img src="{{ $navFeatureImage }}" alt="{{ $navFeature->name }}">
                                                </div>
                                                <div class="content">
                                                    <h5 class="box-text fw-medium text-white">
                                                        <span>New in</span>
                                                        <span class="br-line w-22 bg-white d-block"></span>
                                                        <span>{{ \Illuminate\Support\Str::limit($navFeature->name, 28) }}</span>
                                                    </h5>
                                                    <div class="box-btn">
                                                        <a href="{{ route('shop') }}" class="tf-btn-line style-white text-uppercase">
                                                            <span class="text-caption lh-28">Shop Now</span>
                                                            <i class="icon-arrow-top-right-2 fs-10"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </li>

                        <li class="menu-item {{ request()->routeIs('about') ? 'active' : '' }}">
                            <a href="{{ route('about') }}" class="item-link">About</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="col-xl-2 col-md-4 col-6">
                <a href="{{ route('home') }}" class="logo-site justify-content-center w-100">
                    {{-- Text logo. To use image files instead, replace these two spans with:
                         <img src="{{ asset('images/logo/logo.svg') }}" alt="Moti Atelier" class="logo-black">
                         <img src="{{ asset('images/logo/logo-white.svg') }}" alt="Moti Atelier" class="logo-white"> --}}
                    <span class="logo-black" style="font-family: Georgia, serif; font-size: 22px; letter-spacing: .2em; text-transform: uppercase; color: #1f1b18;">Moti Atelier</span>
                    <span class="logo-white" style="font-family: Georgia, serif; font-size: 22px; letter-spacing: .2em; text-transform: uppercase; color: #fff;">Moti Atelier</span>
                </a>
            </div>

            <div class="col-xl-5 col-md-4 col-3">
                <div class="header-right justify-content-end align-items-center">
                    <div class="hs-wrap d-none d-xl-block" data-header-search>
                        <form class="form-search style-radius style-white" action="{{ route('search') }}" method="GET">
                            <fieldset>
                                <input type="text" placeholder="Search for anything..." class="bg-transparent" name="q" tabindex="0"
                                    aria-required="true" required minlength="2" autocomplete="off"
                                    aria-expanded="false" aria-controls="hs-panel"
                                    data-hs-input
                                    data-suggest-url="{{ route('search.suggest') }}"
                                    data-placeholder="{{ asset('images/products/product-6.jpg') }}">
                            </fieldset>
                            <button type="submit" class="link"><i class="icon icon-search"></i></button>
                        </form>

                        <div class="hs-panel" id="hs-panel" hidden>
                            <p class="hs-title" data-hs-title>Suggestions for you</p>
                            <ul class="hs-list" data-hs-list>
                                @foreach($navPicks as $p)
                                    <li>
                                        <a href="{{ route('product', $p->slug) }}" class="hs-item">
                                            <img src="{{ $p->getFirstMediaUrl('gallery', 'card') ?: asset('images/products/product-6.jpg') }}" alt="">
                                            <span class="hs-name">{{ $p->name }}</span>
                                            <span class="hs-price">{{ $p->stock > 0 ? 'PKR ' . number_format($p->price) : 'Sold out' }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            @if($navCollections->isNotEmpty())
                                <div class="hs-links" data-hs-links>
                                    @foreach($navCollections as $c)
                                        <a href="{{ route('collection', $c->slug) }}">{{ $c->name }}</a>
                                    @endforeach
                                </div>
                            @endif
                            <a href="{{ route('search') }}" class="hs-all" data-hs-all hidden>See all results</a>
                        </div>
                    </div>
                    <ul class="nav-icon">
                        <li class="d-inline-flex d-xl-none">
                            <a href="#search" data-bs-toggle="offcanvas" class="nav-icon-item text-black link" aria-label="Search">
                                <i class="icon icon-search"></i>
                            </a>
                        </li>
                        <li class="d-inline-flex">
                            <a href="#shoppingCart" data-bs-toggle="offcanvas" class="nav-icon-item text-black link" aria-label="Open cart">
                                <i class="icon icon-cart"></i>
                                <span class="count-notice" data-cart-count>{{ \App\Support\Cart::count() }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- /Header -->

<style>
    .hs-wrap { position: relative; }
    .hs-panel { position: absolute; top: calc(100% + 10px); right: 0; width: 380px; max-width: 90vw; padding: 16px; background: #fff; color: #1f1b18; text-align: left; box-shadow: 0 12px 40px rgba(0, 0, 0, .15); z-index: 1000; }
    .hs-panel[hidden] { display: none; }
    .hs-title { margin: 0 0 8px; font-size: 12px; letter-spacing: .12em; text-transform: uppercase; color: #6b645c; }
    .hs-list { list-style: none; margin: 0; padding: 0; }
    .hs-item { display: flex; align-items: center; gap: 12px; padding: 8px; color: inherit; text-decoration: none; }
    .hs-item:hover, .hs-item.is-active { background: #f6f1e8; }
    .hs-item img { width: 48px; height: 48px; object-fit: cover; background: #f3eee4; flex-shrink: 0; }
    .hs-name { flex: 1; font-size: 14px; }
    .hs-price { font-size: 13px; color: #6b645c; white-space: nowrap; }
    .hs-empty { padding: 8px; font-size: 14px; color: #6b645c; }
    .hs-links { margin-top: 12px; padding-top: 12px; border-top: 1px solid rgba(0, 0, 0, .08); }
    .hs-links a { display: inline-block; margin: 0 8px 6px 0; padding: 4px 12px; border: 1px solid rgba(0, 0, 0, .2); border-radius: 999px; font-size: 13px; color: inherit; text-decoration: none; }
    .hs-all { display: block; margin-top: 10px; font-size: 14px; text-align: center; color: inherit; text-decoration: underline; }
    .hs-all[hidden] { display: none; }
</style>