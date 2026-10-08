<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    {{-- 1. Dynamic Title --}}
    <title>{{ $title ?? 'Moti Atelier' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- 2. Google Fonts from existing app --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    
    <!-- Vemus Fonts & Icons -->
    <link rel="stylesheet" href="{{ asset('fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('icon/icomoon/style.css') }}">
    
    <!-- Vemus CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="https://sibforms.com/forms/end-form/build/sib-styles.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo/short-logo.svg') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/logo/short-logo.svg') }}">

    {{-- 3. Vite Assets from existing app --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-surface">

    <!-- Scroll Top -->
    <button id="goTop">
        <span class="border-progress"></span>
        <span class="icon icon-arrow-right-2"></span>
    </button>

    <!-- preload -->
    <div class="preload preload-container" id="preload">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- /preload -->

    <div id="wrapper">
        
        <!-- Top Bar-->
        <div class="tf-topbar bg-olive-brown">
            <div class="container">
                <div class="topbar-inner">
                    <div dir="ltr" class="swiper tf-swiper" data-loop="true" data-auto="true" data-delay="3000" data-speed="1000" data-space="10" data-direction="vertical">
                        <div class="swiper-wrapper">
                            <!-- item 1 -->
                            <div class="swiper-slide">
                                <div class="has-btn">
                                    <p class="text-caption-3 fw-medium text-white">
                                        FREE STANDARD DELIVERY FOR ALL ORDERS OVER $200
                                    </p>
                                    <span class="br-line"></span>
                                    <a href="{{ route('home') }}#collections" class="tf-btn-line style-white-2 text-uppercase lh-19">
                                        Shop Now
                                        <i class="icon-arrow-top-right-2 fs-10"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Top Bar -->

        <!-- Header -->
        <header class="tf-header line-bt-2">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Mobile Menu Toggle -->
                    <div class="col-md-4 col-3 d-xl-none">
                        <a href="#mobileMenu" data-bs-toggle="offcanvas" class="btn-mobile-menu">
                            <span></span>
                        </a>
                    </div>
                    
                    <!-- Logo / Brand -->
                    <div class="col-xl-2 col-md-4 col-6 text-center text-xl-start">
                        <a href="{{ route('home') }}" class="logo-site">
                            <span class="font-serif text-2xl tracking-[0.2em] uppercase">Moti Atelier</span>
                        </a>
                    </div>
                    
                    <!-- Desktop Navigation -->
                    <div class="col-xl-8 d-none d-xl-block">
                        <nav class="box-navigation justify-content-center">
                            <ul class="box-nav-menu">
                                {{-- 4. Routes injected here --}}
                                <li class="menu-item"><a href="{{ route('home') }}" class="item-link">Home</a></li>
                                <li class="menu-item"><a href="{{ route('about') }}" class="item-link">About</a></li>
                                <li class="menu-item"><a href="{{ route('home') }}#collections" class="item-link">Collections</a></li>
                            </ul>
                        </nav>
                    </div>
                    
                    <!-- Right Icons (Cart) -->
                
                    <div class="col-xl-2 col-md-4 col-3">
                        <ul class="nav-icon">
                            <li class="d-inline-flex">
                                <a href="#search" data-bs-toggle="offcanvas" class="nav-icon-item text-black link" aria-label="Search">
                                    <i class="icon icon-search"></i>
                                </a>
                            </li>
                            <li class="br-line d-none d-xl-flex"></li>
                            <li class="d-none d-md-inline-flex">
                                <a href="#log" data-bs-toggle="modal" class="nav-icon-item text-black link">
                                    <i class="icon icon-user"></i>
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
        </header>
        <!-- /Header -->

        {{-- 6. Main Content Area --}}
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="tf-footer style-2 bg-dark-brown ">
            <div class="footer-body p-xl-0">
                <div class="container">
                    <div class="footer-inner-wrap d-xl-flex flex-xl-nowrap">
                        <div class="footer-infor">
                            <div class="box-title">
                                <a href="home-2.html" class="logo-site d-inline-block">
                                    <img src="images/logo/logo-white.svg" alt="">
                                </a>

                                <p class="text-main-5 lt-sp-nor">
                                    <span class="text-white">Explore</span>
                                    our curated collections designed to
                                    <span class="text-white">elevate every <br class="d-none d-xl-block"> look</span>
                                    , from
                                    <span class="text-white">timeless essentials</span>
                                    to
                                    <span class="text-white">trendsetting pieces</span>
                                    . Step <br class="d-none d-xl-block"> in and find the
                                    <span class="text-white">perfect match</span>
                                    for your
                                    <span class="text-white">unique</span>
                                    style.
                                </p>
                            </div>
                            <ul class="tf-social-icon style-white">
                                <li>
                                    <a href="https://www.facebook.com/" target="_blank" class="social-facebook">
                                        <span class="icon"><i class="icon-facebook"></i></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/" target="_blank" class="social-instagram">
                                        <span class="icon"><i class="icon-instagram"></i></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://x.com/" target="_blank" class="social-x">
                                        <span class="icon"><i class="icon-x"></i></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.snapchat.com/" target="_blank" class="social-snapchat">
                                        <span class="icon"><i class="icon-snapchat"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="footer-col-block">
                            <p class="footer-heading footer-heading-mobile text-white font-2">
                                Explore
                            </p>
                            <div class="tf-collapse-content">
                                <ul class="footer-menu-list">
                                    <li><a href="shop-collection-list.html" class="text-white link">Bracelets</a></li>
                                    <li><a href="shop-collection-list.html" class="text-white link">Rings</a></li>
                                    <li><a href="shop-collection-list.html" class="text-white link">Necklaces</a></li>
                                    <li><a href="shop-collection-list.html" class="text-white link">Earrings</a></li>
                                    <li><a href="shop-collection-list.html" class="text-white link">Gifts</a></li>
                                    <li><a href="shop-collection-list.html" class="text-white link">Collections</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="footer-col-block">
                            <p class="footer-heading footer-heading-mobile text-white font-2">
                                HELP
                            </p>
                            <div class="tf-collapse-content">
                                <ul class="footer-menu-list">
                                    <li><a href="faq.html" class="text-white link">FAQs</a></li>
                                    <li><a href="term-condition.html" class="text-white link">Terms & Conditions</a></li>
                                    <li><a href="privacy.html" class="text-white link">Privacy Policies</a></li>
                                    <li><a href="return.html" class="text-white link">Returns & Refunds</a></li>
                                    <li><a href="shipping.html" class="text-white link">Shipping</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="footer-col-block">
                            <p class="footer-heading footer-heading-mobile text-white font-2">
                                Store Information
                            </p>
                            <div class="tf-collapse-content">
                                <ul class="footer-menu-list">
                                    <li class="text-caption">
                                        <span class="fw-medium text-white">Email: </span>
                                        <a href="mailto:clientcare@ecom.com" class="text-white link fw-normal">clientcare@ecom.com</a>
                                    </li>
                                    <li class="text-caption">
                                        <span class="fw-medium text-white">Phone: </span>
                                        <a href="tel:18888383022" class="text-white link fw-normal">1.888.838.3022</a>
                                    </li>
                                    <li class="text-caption">

                                        <a target="_blank" href="https://www.google.com/maps?q=123+Yarran+st,Punchbowl,NSW+2196,Australia"
                                            class="text-white link fw-normal">
                                            <span class="fw-medium text-white">Address: </span>
                                            123 Yarran st, Punchbowl, <br class="d-none d-xl-block">
                                            NSW 2196, Australia
                                        </a>
                                    </li>
                                    <li>
                                        <a href="our-store.html" class="tf-btn-line style-white">
                                            <span class="text-caption">
                                                Get direction
                                            </span>
                                            <i class="icon-arrow-right-2 fs-16"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="footer-bottom-wrap">
                        <p class="text-nocopy text-white">
                            All Rights Reserved 2025 VEMUS.
                        </p>
                        <div class="tf-currencies">
                            <select class="tf-dropdown-select style-default type-currencies color-white">
                                <option selected>United States (USD $)</option>
                                <option>France (EUR €)</option>
                                <option>Germany (EUR €)</option>
                                <option>Vietnam (VND ₫)</option>
                            </select>
                        </div>
                        <ul class="paymend-method-list">
                            <li><a href="#"><img src="images/payment/am-ex.svg" alt="Paymend Method"></a></li>
                            <li><a href="#"><img src="images/payment/apple-pay.svg" alt="Paymend Method"></a></li>
                            <li><a href="#"><img src="images/payment/dinner.svg" alt="Paymend Method"></a></li>
                            <li><a href="#"><img src="images/payment/discover.svg" alt="Paymend Method"></a></li>
                            <li><a href="#"><img src="images/payment/gg-pay.svg" alt="Paymend Method"></a></li>
                            <li><a href="#"><img src="images/payment/master-2.svg" alt="Paymend Method"></a></li>
                            <li><a href="#"><img src="images/payment/master.svg" alt="Paymend Method"></a></li>
                            <li><a href="#"><img src="images/payment/shop-pay.svg" alt="Paymend Method"></a></li>
                            <li><a href="#"><img src="images/payment/unicon-pay.svg" alt="Paymend Method"></a></li>
                            <li><a href="#"><img src="images/payment/visa.svg" alt="Paymend Method"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="logo-bottom wow fadeInUp" data-wow-delay="0.1s">
                <div class="container">
                    <div class="d-flex justify-content-center">
                        <img src="images/logo/logo-very-large.svg" class="lazyload" alt="Logo">
                    </div>
                </div>
            </div>
        </footer>
        <!-- /Footer -->

    </div>

    @include('partials.quick-view-modal')

    @include('partials.mobile-menu')

    @include('partials.cart-drawer')

    @include('partials.search-offcanvas')

    <!-- Javascript -->
    {{-- Wrapped all JS scripts in asset() to ensure they load from your public folder --}}
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('js/carousel.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/lazysize.min.js') }}"></script>
    <script src="{{ asset('js/infinityslide.js') }}"></script>
    <script src="{{ asset('js/gsap.min.js') }}"></script>
    <script src="{{ asset('js/ScrollTrigger.min.js') }}"></script>
    <script src="{{ asset('js/SplitText.min.js') }}"></script>
    <script src="{{ asset('js/parallaxie.js') }}"></script>
    <script src="{{ asset('js/count-down.js') }}"></script>
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/sibforms.js') }}" defer></script>
    <script src="{{ asset('js/store.js') }}"></script>
    <script>
        window.REQUIRED_CODE_ERROR_MESSAGE = 'Please choose a country code';
        window.LOCALE = 'en';
        window.EMAIL_INVALID_MESSAGE = window.SMS_INVALID_MESSAGE = "The information provided is invalid. Please review the field format and try again.";
        window.REQUIRED_ERROR_MESSAGE = "This field cannot be left blank. ";
        window.GENERIC_INVALID_MESSAGE = "The information provided is invalid. Please review the field format and try again.";
        window.translation = {
            common: {
                selectedList: '{quantity} list selected',
                selectedLists: '{quantity} lists selected'
            }
        };
        var AUTOHIDE = Boolean(0);
    </script>
</body>
</html>