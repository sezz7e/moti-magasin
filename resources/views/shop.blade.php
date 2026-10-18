@extends('layouts.app')

<!-- Product -->
<div class="flat-spacing pt-0">
    <div class="container">
        <div class="tf-shop-control">
            <div class="tf-control-filter">
                <div class="tf-filter-dropdown">
                    <p class="title-filter h5">
                        <span class="text">FILTER</span>
                    </p>
                    <div class="meta-dropdown-filter">
                        <div class="dropdown dropdown-filter">
                            <div class="dropdown-toggle" id="availability" data-bs-toggle="dropdown" aria-expanded="false"
                                data-bs-auto-close="outside" role="button">
                                <span class="text-uppercase">AVAILABILITY</span>
                                <span class="icon icon-arrow-angle-down"></span>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="availability">
                                <ul class="filter-group-check">
                                    <li class="list-item">
                                        <input type="radio" name="availability" class="tf-check style-2" id="inStock">
                                        <label for="inStock" class="label">
                                            <span>In Stock</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                                        </label>
                                    </li>
                                    <li class="list-item disabled">
                                        <input type="radio" name="availability" class="tf-check style-2" id="outStock">
                                        <label for="outStock" class="label">
                                            <span>Out of Stock</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="dropdown dropdown-filter">
                            <div class="dropdown-toggle" id="categories" data-bs-toggle="dropdown" aria-expanded="false"
                                data-bs-auto-close="outside" role="button">
                                <span class="text-uppercase">CATEGORY</span>
                                <span class="icon icon-arrow-angle-down"></span>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="categories">
                                <ul class="filter-group-check">
                                    <li class="list-item">
                                        <input type="checkbox" name="category" class="tf-check style-2" id="bracelet">
                                        <label for="bracelet" class="label">
                                            <span>Bracelets</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                                        </label>
                                    </li>
                                    <li class="list-item">
                                        <input type="checkbox" name="category" class="tf-check style-2" id="earring">
                                        <label for="earring" class="label">
                                            <span>Earrings</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                                        </label>
                                    </li>
                                    <li class="list-item">
                                        <input type="checkbox" name="category" class="tf-check style-2" id="ring">
                                        <label for="ring" class="label">
                                            <span>Rings</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                                        </label>
                                    </li>
                                    <li class="list-item">
                                        <input type="checkbox" name="category" class="tf-check style-2" id="necklace">
                                        <label for="necklace" class="label">
                                            <span>Necklaces</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                                        </label>
                                    </li>
                                    <li class="list-item">
                                        <input type="checkbox" name="category" class="tf-check style-2" id="new-in">
                                        <label for="new-in" class="label">
                                            <span>New In</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                                        </label>
                                    </li>
                                    <li class="list-item">
                                        <input type="checkbox" name="category" class="tf-check style-2" id="gift-idea">
                                        <label for="gift-idea" class="label">
                                            <span>Gift ideas</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="dropdown dropdown-filter">
                            <div class="dropdown-toggle" id="materials" data-bs-toggle="dropdown" aria-expanded="false"
                                data-bs-auto-close="outside" role="button">
                                <span class="text-uppercase">METAL COLOR</span>
                                <span class="icon icon-arrow-angle-down"></span>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="materials">
                                <ul class="filter-group-check">
                                    <li class="list-item">
                                        <input type="checkbox" name="material" class="tf-check style-2" id="gold">
                                        <label for="gold" class="label">
                                            <span>Gold</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                                        </label>
                                    </li>
                                    <li class="list-item">
                                        <input type="checkbox" name="material" class="tf-check style-2" id="sterling-silver">
                                        <label for="sterling-silver" class="label">
                                            <span>Sterling Silver</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                                        </label>
                                    </li>
                                    <li class="list-item">
                                        <input type="checkbox" name="material" class="tf-check style-2" id="white-gold">
                                        <label for="white-gold" class="label">
                                            <span>White Gold</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                                        </label>
                                    </li>
                                    <li class="list-item">
                                        <input type="checkbox" name="material" class="tf-check style-2" id="pink-gold">
                                        <label for="pink-gold" class="label">
                                            <span>Pink Gold</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="dropdown dropdown-filter">
                            <div class="dropdown-toggle" id="stone-color" data-bs-toggle="dropdown" aria-expanded="false"
                                data-bs-auto-close="outside" role="button">
                                <span class="text-uppercase">stone colour</span>
                                <span class="icon icon-arrow-angle-down"></span>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="stone-color">
                                <ul class="filter-group-check">
                                    <li class="list-item">

                                        <input type="checkbox" name="color" class="tf-check style-2" id="blue">
                                        <label for="blue" class="label">
                                            <img src="images/products/material/dia-blue.jpg" alt="Colour" class="img-check">
                                            <span>Blue</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                                        </label>
                                    </li>
                                    <li class="list-item">
                                        <input type="checkbox" name="color" class="tf-check style-2" id="pink">
                                        <label for="pink" class="label">
                                            <img src="images/products/material/dia-pink.jpg" alt="Colour" class="img-check">
                                            <span>Pink</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                                        </label>
                                    </li>
                                    <li class="list-item">
                                        <input type="checkbox" name="color" class="tf-check style-2" id="white">
                                        <label for="white" class="label">
                                            <img src="images/products/material/dia-white.jpg" alt="Colour" class="img-check">
                                            <span>White</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="dropdown dropdown-filter">
                            <div class="dropdown-toggle" id="price" data-bs-toggle="dropdown" aria-expanded="false"
                                data-bs-auto-close="outside" role="button">
                                <span class="text-uppercase">price</span>
                                <span class="icon icon-arrow-angle-down"></span>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="price">
                                <ul class="filter-group-check">
                                    <li class="list-item">
                                        <input type="radio" name="price" class="tf-check style-2" id="u-500">
                                        <label for="u-500" class="label">
                                            <span>Under $500</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                                        </label>
                                    </li>
                                    <li class="list-item">
                                        <input type="radio" name="price" class="tf-check style-2" id="u-1000">
                                        <label for="u-1000" class="label">
                                            <span>Under $1000</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                                        </label>
                                    </li>
                                    <li class="list-item">
                                        <input type="radio" name="price" class="tf-check style-2" id="u-2000">
                                        <label for="u-2000" class="label">
                                            <span>Under $2000</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                                        </label>
                                    </li>
                                    <li class="list-item">
                                        <input type="radio" name="price" class="tf-check style-2" id="up-2000">
                                        <label for="up-2000" class="label">
                                            <span>Over $2000</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="dropdown dropdown-filter">
                            <div class="dropdown-toggle" id="size" data-bs-toggle="dropdown" aria-expanded="false"
                                data-bs-auto-close="outside" role="button">
                                <span class="text-uppercase">size</span>
                                <span class="icon icon-arrow-angle-down"></span>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="size">
                                <div class="filter-size-box flat-check-list">
                                    <div class="check-item size-item size-check"><span class="count size">5</span></div>
                                    <div class="check-item size-item size-check"><span class="count size">6</span></div>
                                    <div class="check-item size-item size-check"><span class="count size">7</span></div>
                                    <div class="check-item size-item size-check"><span class="count size">8</span></div>
                                    <div class="check-item size-item size-check"><span class="count size">9</span></div>
                                    <div class="check-item size-item size-check disabled"><span class="count size">10</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tf-group-layout type-drop">
                <ul class="tf-control-layout">
                    <li class="tf-view-layout-switch sw-layout-2 d-none d-md-flex" data-value-layout="tf-col-2">
                        <div class="item icon-grid-2">
                            <span></span>
                            <span></span>
                        </div>
                    </li>
                    <li class="tf-view-layout-switch sw-layout-3 d-none d-md-flex" data-value-layout="tf-col-3">
                        <div class="item icon-grid-3">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </li>
                    <li class="tf-view-layout-switch sw-layout-4 active d-none d-xl-flex" data-value-layout="tf-col-4">
                        <div class="item icon-grid-4">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </li>

                </ul>
                <div class="tf-dropdown-sort" data-bs-toggle="dropdown">
                    <div class="btn-select">
                        <span class="text-sort-value">Best selling</span>
                        <span class="icon icon-arrow-angle-down"></span>
                    </div>
                    <div class="dropdown-menu">
                        <div class="select-item active" data-sort-value="best-selling">
                            <span class="text-value-item">Best selling</span>
                        </div>
                        <div class="select-item" data-sort-value="a-z">
                            <span class="text-value-item">Alphabetically, A-Z</span>
                        </div>
                        <div class="select-item" data-sort-value="z-a">
                            <span class="text-value-item">Alphabetically, Z-A</span>
                        </div>
                        <div class="select-item" data-sort-value="price-low-high">
                            <span class="text-value-item">Price, low to high</span>
                        </div>
                        <div class="select-item" data-sort-value="price-high-low">
                            <span class="text-value-item">Price, high to low</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="meta-filter-shop type-drop" style="display: none;">

            <div id="applied-filters"></div>
            <button id="remove-all" class="remove-all-filters tf-btn-line">
                <span class="text-body">Clear all</span>
            </button>
        </div>
        <div class="wrapper-control-shop gridLayout-wrapper">
            <div class="wrapper-shop tf-grid-layout tf-col-4" id="gridLayout">
                <!-- Product 1 -->
                <div class="loadItem card_product--V01 grid" data-availability="In stock" data-category="ring" data-material="sterling-silver"
                    data-size="6">
                    <div class="card_product-wrapper">
                        <a href="product-default.html" class="product-img">
                            <img src="images/products/product-1.jpg" data-src="images/products/product-1.jpg" alt="Image Product"
                                class="lazyload img-product">
                            <img src="images/products/product-12.jpg" data-src="images/products/product-12.jpg" alt="Image Product"
                                class="lazyload img-hover">
                        </a>
                        <ul class="list-product-btn">
                            <li class="wishlist">
                                <a href="javascript:void(0);" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-heart-2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                            </li>
                            <li>
                                <a href="#quickAdd" data-bs-toggle="modal" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-shop-cart"></span>
                                    <span class="tooltip">Quick Add</span>
                                </a>
                            </li>
                            <li>
                                <a href="#quickView" data-bs-toggle="modal" class="hover-tooltip tooltip-left box-icon quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                            </li>
                            <li class="compare">
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </li>
                        </ul>
                        <div class="badge-box">
                            <span class="badge-item new">NEW IN</span>
                        </div>
                        <div class="variant-box ">
                            <div class="size-box bg-light-gray text-center">
                                <p class="text-caption">3 sizes are available</p>
                            </div>
                        </div>
                    </div>
                    <div class="card_product-info">
                        <a href="product-default.html" class="name-product h5 fw-normal link text-line-clamp-2">
                            Emerald-cut Halo Engagement Ring with a Diamond Platinum Band
                        </a>
                        <div class="price-wrap">
                            <span class="price-new h5">$3,370.00</span>
                            <span class="price-old fw-normal">$3,899.00</span>
                        </div>
                    </div>
                </div>
                <!-- Product 2 -->
                <div class="loadItem card_product--V01 grid" data-availability="In stock" data-category="bracelet" data-material="white-gold"
                    data-size="5">
                    <div class="card_product-wrapper">
                        <a href="product-default.html" class="product-img">
                            <img src="images/products/product-2.jpg" data-src="images/products/product-2.jpg" alt="Image Product"
                                class="lazyload img-product">
                            <img src="images/products/product-13.jpg" data-src="images/products/product-13.jpg" alt="Image Product"
                                class="lazyload img-hover">
                        </a>
                        <ul class="list-product-btn">
                            <li class="wishlist">
                                <a href="javascript:void(0);" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-heart-2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                            </li>
                            <li>
                                <a href="#shoppingCart" data-bs-toggle="offcanvas" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-shop-cart"></span>
                                    <span class="tooltip">Add to Cart</span>
                                </a>
                            </li>
                            <li>
                                <a href="#quickView" data-bs-toggle="modal" class="hover-tooltip tooltip-left box-icon quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                            </li>
                            <li class="compare">
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card_product-info">
                        <a href="product-default.html" class="name-product h5 fw-normal link text-line-clamp-2">
                            Link Chain Bracelet
                        </a>
                        <div class="price-wrap">
                            <span class="price-new h5">$891.00</span>
                            <span class="price-old fw-normal">$999.00</span>
                        </div>
                    </div>
                </div>
                <!-- Product 3 -->
                <div class="loadItem card_product--V01 grid" data-availability="In stock" data-category="bracelet"
                    data-material="sterling-silver" data-size="9">
                    <div class="card_product-wrapper">
                        <a href="product-default.html" class="product-img">
                            <img src="images/products/product-3.jpg" data-src="images/products/product-3.jpg" alt="Image Product"
                                class="lazyload img-product">
                            <img src="images/products/product-14.jpg" data-src="images/products/product-14.jpg" alt="Image Product"
                                class="lazyload img-hover">
                        </a>
                        <ul class="list-product-btn">
                            <li class="wishlist">
                                <a href="javascript:void(0);" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-heart-2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                            </li>
                            <li>
                                <a href="#shoppingCart" data-bs-toggle="offcanvas" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-shop-cart"></span>
                                    <span class="tooltip">Add to Cart</span>
                                </a>
                            </li>
                            <li>
                                <a href="#quickView" data-bs-toggle="modal" class="hover-tooltip tooltip-left box-icon quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                            </li>
                            <li class="compare">
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </li>
                        </ul>
                        <div class="badge-box">
                            <span class="badge-item sale">30% OFF</span>
                        </div>
                        <div class="variant-box bg-primary">
                            <div class="marquee-sale infiniteSlide" data-clone="2">
                                <!-- clone 1 -->
                                <p class="text-caption text-white">30% OFF</p>
                                <i class="icon-thunder text-white"></i>
                                <!-- clone 2 -->
                                <p class="text-caption text-white">Selling fast</p>
                                <i class="icon-thunder text-white"></i>
                                <!-- clone 3 -->
                                <p class="text-caption text-white">30% OFF</p>
                                <i class="icon-thunder text-white"></i>
                                <!-- clone 4 -->
                                <p class="text-caption text-white">Selling fast</p>
                                <i class="icon-thunder text-white"></i>
                                <!-- clone 5 -->
                                <p class="text-caption text-white">30% OFF</p>
                                <i class="icon-thunder text-white"></i>
                                <!-- clone 6 -->
                                <p class="text-caption text-white">Selling fast</p>
                                <i class="icon-thunder text-white"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card_product-info">
                        <a href="product-default.html" class="name-product h5 fw-normal link text-line-clamp-2">
                            Sparkling Infinity Heart Clasp Snake Chain Bracelet
                        </a>
                        <div class="price-wrap">
                            <span class="price-new h5">$2,499.00</span>
                            <span class="price-old fw-normal">$2,899.00</span>
                        </div>
                    </div>
                </div>
                <!-- Product 4 -->
                <div class="loadItem card_product--V01 grid out-of-stock" data-availability="Out of stock" data-category="bracelet"
                    data-size="8">
                    <div class="card_product-wrapper">
                        <a href="product-notify-avaiable.html" class="product-img">
                            <img src="images/products/product-4.jpg" data-src="images/products/product-4.jpg" alt="Image Product"
                                class="lazyload img-product">
                            <img src="images/products/product-15.jpg" data-src="images/products/product-15.jpg" alt="Image Product"
                                class="lazyload img-hover">
                        </a>
                        <a href="#unavailable" data-bs-toggle="modal" class="variant-box stock bg-main link text-white">
                            <p class="text-center d-none d-md-block">Notify Me When Available</p>
                            <p class="text-center d-md-none">Notify Me</p>
                        </a>
                    </div>
                    <div class="card_product-info">
                        <a href="product-notify-avaiable.html" class="name-product h5 fw-normal link text-line-clamp-2">
                            Sparkling Infinity Heart Clasp Snake Chain Bracelet
                        </a>
                        <div class="price-wrap">
                            <span class="price-new h5">$773.00</span>
                            <span class="price-old fw-normal">$899.00</span>
                        </div>
                    </div>
                </div>
                <!-- Product 5 -->
                <div class="loadItem tempo box_image--V02 hover-img">
                    <a href="shop-collection-list.html" class="box_image-image img-style">
                        <img src="images/collections/discover-1.jpg" data-src="images/collections/discover-1.jpg" alt="" class="lazyload">
                    </a>
                    <div class="box_image-content align-items-center text-center">
                        <a href="shop-collection-list.html" class="title h3 fw-normal font-2 text-white link-secondary">
                            <span class="fst-italic">Diamond</span> For All
                        </a>
                        <a href="shop-collection-list.html" class="tf-btn style-3 btn-fill-white animate-btn animate-dark">
                            <span class="fw-medium text-uppercase">discover <span class="d-none d-sm-inline">now</span></span>
                        </a>
                    </div>
                </div>
                <!-- Product 6 -->
                <div class=" loadItem card_product--V01 grid" data-availability="In stock" data-category="bracelet"
                    data-material="sterling-silver" data-size="6">
                    <div class="card_product-wrapper">
                        <a href="product-default.html" class="product-img">
                            <img src="images/products/product-16.jpg" data-src="images/products/product-16.jpg" alt="Image Product"
                                class="lazyload img-product">
                            <img src="images/products/product-17.jpg" data-src="images/products/product-17.jpg" alt="Image Product"
                                class="lazyload img-hover">
                        </a>
                        <ul class="list-product-btn">
                            <li class="wishlist">
                                <a href="javascript:void(0);" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-heart-2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                            </li>
                            <li>
                                <a href="#shoppingCart" data-bs-toggle="offcanvas" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-shop-cart"></span>
                                    <span class="tooltip">Add to Cart</span>
                                </a>
                            </li>
                            <li>
                                <a href="#quickView" data-bs-toggle="modal" class="hover-tooltip tooltip-left box-icon quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                            </li>
                            <li class="compare">
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card_product-info">
                        <a href="product-default.html" class="name-product h5 fw-normal link text-line-clamp-2">
                            Infinite Lab-Grown Diamond Bangle
                        </a>
                        <div class="price-wrap">
                            <span class="price-new h5">$1,847.00</span>
                            <span class="price-old fw-normal">$2,599.00</span>
                        </div>
                    </div>
                </div>
                <!-- Product 7 -->
                <div class="loadItem card_product--V01 grid" data-availability="In stock" data-category="ring" data-material="sterling-silver"
                    data-size="6">
                    <div class="card_product-wrapper">
                        <a href="product-default.html" class="product-img">
                            <img src="images/products/product-18.jpg" data-src="images/products/product-18.jpg" alt="Image Product"
                                class="lazyload img-product">
                            <img src="images/products/product-19.jpg" data-src="images/products/product-19.jpg" alt="Image Product"
                                class="lazyload img-hover">
                        </a>
                        <ul class="list-product-btn">
                            <li class="wishlist">
                                <a href="javascript:void(0);" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-heart-2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                            </li>
                            <li>
                                <a href="#shoppingCart" data-bs-toggle="offcanvas" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-shop-cart"></span>
                                    <span class="tooltip">Add to Cart</span>
                                </a>
                            </li>
                            <li>
                                <a href="#quickView" data-bs-toggle="modal" class="hover-tooltip tooltip-left box-icon quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                            </li>
                            <li class="compare">
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </li>
                        </ul>
                        <div class="badge-box">
                            <span class="badge-item sale">30% OFF</span>
                        </div>
                    </div>
                    <div class="card_product-info">
                        <a href="product-default.html" class="name-product h5 fw-normal link text-line-clamp-2">
                            Olive Leaf Band Ring
                        </a>
                        <div class="price-wrap">
                            <span class="price-new h5">$327.00</span>
                            <span class="price-old fw-normal">$899.00</span>
                        </div>
                    </div>
                </div>
                <!-- Product 8 -->
                <div class="loadItem card_product--V01 grid" data-availability="In stock" data-category="bracelet" data-material="gold"
                    data-size="9">
                    <div class="card_product-wrapper">
                        <a href="product-default.html" class="product-img">
                            <img src="images/products/product-20.jpg" data-src="images/products/product-20.jpg" alt="Image Product"
                                class="lazyload img-product">
                            <img src="images/products/product-21.jpg" data-src="images/products/product-21.jpg" alt="Image Product"
                                class="lazyload img-hover">
                        </a>
                        <ul class="list-product-btn">
                            <li class="wishlist">
                                <a href="javascript:void(0);" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-heart-2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                            </li>
                            <li>
                                <a href="#shoppingCart" data-bs-toggle="offcanvas" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-shop-cart"></span>
                                    <span class="tooltip">Add to Cart</span>
                                </a>
                            </li>
                            <li>
                                <a href="#quickView" data-bs-toggle="modal" class="hover-tooltip tooltip-left box-icon quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                            </li>
                            <li class="compare">
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card_product-info">
                        <a href="product-default.html" class="name-product h5 fw-normal link text-line-clamp-2">
                            Organically Shaped Heart Bangle
                        </a>
                        <div class="price-wrap">
                            <span class="price-new h5">$3,888.00</span>
                            <span class="price-old fw-normal">$4,899.00</span>
                        </div>
                    </div>
                </div>
                <!-- Product 9 -->
                <div class="loadItem card_product--V01 grid" data-availability="In stock" data-category="bracelet"
                    data-material="sterling-silver" data-size="5">
                    <div class="card_product-wrapper">
                        <a href="product-default.html" class="product-img">
                            <img src="images/products/product-22.jpg" data-src="images/products/product-22.jpg" alt="Image Product"
                                class="lazyload img-product">
                            <img src="images/products/product-23.jpg" data-src="images/products/product-23.jpg" alt="Image Product"
                                class="lazyload img-hover">
                        </a>
                        <ul class="list-product-btn">
                            <li class="wishlist">
                                <a href="javascript:void(0);" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-heart-2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                            </li>
                            <li>
                                <a href="#shoppingCart" data-bs-toggle="offcanvas" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-shop-cart"></span>
                                    <span class="tooltip">Add to Cart</span>
                                </a>
                            </li>
                            <li>
                                <a href="#quickView" data-bs-toggle="modal" class="hover-tooltip tooltip-left box-icon quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                            </li>
                            <li class="compare">
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card_product-info">
                        <a href="product-default.html" class="name-product h5 fw-normal link text-line-clamp-2">
                            Open Heart Bangle
                        </a>
                        <div class="price-wrap">
                            <span class="price-new h5">$214.00</span>
                            <span class="price-old fw-normal">$399.00</span>
                        </div>
                    </div>
                </div>
                <!-- Product 10 -->
                <div class="loadItem card_product--V01 grid" data-availability="In stock" data-category="bracelet" data-material="white-gold"
                    data-size="7">
                    <div class="card_product-wrapper">
                        <a href="product-default.html" class="product-img">
                            <img src="images/products/product-24.jpg" data-src="images/products/product-24.jpg" alt="Image Product"
                                class="lazyload img-product">
                            <img src="images/products/product-25.jpg" data-src="images/products/product-25.jpg" alt="Image Product"
                                class="lazyload img-hover">
                        </a>
                        <ul class="list-product-btn">
                            <li class="wishlist">
                                <a href="javascript:void(0);" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-heart-2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                            </li>
                            <li>
                                <a href="#shoppingCart" data-bs-toggle="offcanvas" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-shop-cart"></span>
                                    <span class="tooltip">Add to Cart</span>
                                </a>
                            </li>
                            <li>
                                <a href="#quickView" data-bs-toggle="modal" class="hover-tooltip tooltip-left box-icon quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                            </li>
                            <li class="compare">
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card_product-info">
                        <a href="product-default.html" class="name-product h5 fw-normal link text-line-clamp-2">
                            Crystal Birthstone Eternity Circle Charm
                        </a>
                        <div class="price-wrap">
                            <span class="price-new h5">$865.00</span>
                            <span class="price-old fw-normal">$999.00</span>
                        </div>
                    </div>
                </div>
                <!-- Product 11 -->
                <div class="loadItem card_product--V01 grid" data-availability="In stock" data-category="bracelet"
                    data-material="sterling-silver" data-size="8">
                    <div class="card_product-wrapper">
                        <a href="product-default.html" class="product-img">
                            <img src="images/products/product-26.jpg" data-src="images/products/product-26.jpg" alt="Image Product"
                                class="lazyload img-product">
                            <img src="images/products/product-27.jpg" data-src="images/products/product-27.jpg" alt="Image Product"
                                class="lazyload img-hover">
                        </a>
                        <ul class="list-product-btn">
                            <li class="wishlist">
                                <a href="javascript:void(0);" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-heart-2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                            </li>
                            <li>
                                <a href="#shoppingCart" data-bs-toggle="offcanvas" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-shop-cart"></span>
                                    <span class="tooltip">Add to Cart</span>
                                </a>
                            </li>
                            <li>
                                <a href="#quickView" data-bs-toggle="modal" class="hover-tooltip tooltip-left box-icon quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                            </li>
                            <li class="compare">
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card_product-info">
                        <a href="product-default.html" class="name-product h5 fw-normal link text-line-clamp-2">
                            Ball Bracelet
                        </a>
                        <div class="price-wrap">
                            <span class="price-new h5">$1,766.00</span>
                            <span class="price-old fw-normal">$2,199.00</span>
                        </div>
                    </div>
                </div>
                <!-- Product 12 -->
                <div class="loadItem card_product--V01 grid" data-availability="In stock" data-category="ring" data-material="pink-gold"
                    data-size="6">
                    <div class="card_product-wrapper">
                        <a href="product-default.html" class="product-img">
                            <img src="images/products/product-28.jpg" data-src="images/products/product-28.jpg" alt="Image Product"
                                class="lazyload img-product">
                            <img src="images/products/product-29.jpg" data-src="images/products/product-29.jpg" alt="Image Product"
                                class="lazyload img-hover">
                        </a>
                        <ul class="list-product-btn">
                            <li class="wishlist">
                                <a href="javascript:void(0);" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-heart-2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                            </li>
                            <li>
                                <a href="#shoppingCart" data-bs-toggle="offcanvas" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-shop-cart"></span>
                                    <span class="tooltip">Add to Cart</span>
                                </a>
                            </li>
                            <li>
                                <a href="#quickView" data-bs-toggle="modal" class="hover-tooltip tooltip-left box-icon quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                            </li>
                            <li class="compare">
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card_product-info">
                        <a href="product-default.html" class="name-product h5 fw-normal link text-line-clamp-2">
                            Engagement Ring in 18k Yellow Gold
                        </a>
                        <div class="price-wrap">
                            <span class="price-new h5">$1,583.00</span>
                            <span class="price-old fw-normal">$1,899.00</span>
                        </div>
                    </div>
                </div>
                <!-- Product 13 -->
                <div class="loadItem card_product--V01 grid" data-availability="In stock" data-category="bracelet" data-material="white-gold"
                    data-size="9">
                    <div class="card_product-wrapper">
                        <a href="product-default.html" class="product-img">
                            <img src="images/products/product-30.jpg" data-src="images/products/product-30.jpg" alt="Image Product"
                                class="lazyload img-product">
                            <img src="images/products/product-31.jpg" data-src="images/products/product-31.jpg" alt="Image Product"
                                class="lazyload img-hover">
                        </a>
                        <ul class="list-product-btn">
                            <li class="wishlist">
                                <a href="javascript:void(0);" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-heart-2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                            </li>
                            <li>
                                <a href="#shoppingCart" data-bs-toggle="offcanvas" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-shop-cart"></span>
                                    <span class="tooltip">Add to Cart</span>
                                </a>
                            </li>
                            <li>
                                <a href="#quickView" data-bs-toggle="modal" class="hover-tooltip tooltip-left box-icon quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                            </li>
                            <li class="compare">
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </li>
                        </ul>
                        <div class="badge-box">
                            <span class="badge-item sale">30% OFF</span>
                        </div>
                    </div>
                    <div class="card_product-info">
                        <a href="product-default.html" class="name-product h5 fw-normal link text-line-clamp-2">
                            Wire Bangle
                        </a>
                        <div class="price-wrap">
                            <span class="price-new h5">$142.00</span>
                            <span class="price-old fw-normal">$599.00</span>
                        </div>
                    </div>
                </div>
                <!-- Product 14 -->
                <div class="loadItem card_product--V01 grid" data-availability="In stock" data-category="bracelet" data-material="gold"
                    data-size="5">
                    <div class="card_product-wrapper">
                        <a href="product-default.html" class="product-img">
                            <img src="images/products/product-32.jpg" data-src="images/products/product-32.jpg" alt="Image Product"
                                class="lazyload img-product">
                            <img src="images/products/product-33.jpg" data-src="images/products/product-33.jpg" alt="Image Product"
                                class="lazyload img-hover">
                        </a>
                        <ul class="list-product-btn">
                            <li class="wishlist">
                                <a href="javascript:void(0);" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-heart-2"></span>
                                    <span class="tooltip">Add to Wishlist</span>
                                </a>
                            </li>
                            <li>
                                <a href="#shoppingCart" data-bs-toggle="offcanvas" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-shop-cart"></span>
                                    <span class="tooltip">Add to Cart</span>
                                </a>
                            </li>
                            <li>
                                <a href="#quickView" data-bs-toggle="modal" class="hover-tooltip tooltip-left box-icon quickview">
                                    <span class="icon icon-view"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                            </li>
                            <li class="compare">
                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare" class="hover-tooltip tooltip-left box-icon">
                                    <span class="icon icon-compare"></span>
                                    <span class="tooltip">Add to Compare</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card_product-info">
                        <a href="product-default.html" class="name-product h5 fw-normal link text-line-clamp-2">
                            Curb Link Bracelet
                        </a>
                        <div class="price-wrap">
                            <span class="price-new h5">$3,210.00</span>
                            <span class="price-old fw-normal">$3,599.00</span>
                        </div>
                    </div>
                </div>
                <!-- Product 15 16 -->
                <div class="loadItem tempo wd-2-cols box_image--V02 style-2 hover-img">
                    <a href="shop-collection-list.html" class="box_image-image img-style">
                        <img src="images/collections/discover-2.jpg" data-src="images/collections/discover-2.jpg" alt="" class="lazyload">
                    </a>
                    <div class="box_image-content type-left">
                        <div class="heading">
                            <p class="fw-medium text-white text-uppercase">be love</p>
                            <a href="shop-collection-list.html" class="title h2 fw-normal font-2 text-white link link-secondary">
                                Be <span class="fst-italic">Unmissable.</span>
                            </a>
                        </div>
                        <a href="shop-collection-list.html" class="tf-btn style-3 btn-fill-white animate-btn animate-dark">
                            <span class="fw-medium text-uppercase">discover more</span>
                        </a>
                    </div>
                </div>
                <!-- Pagination -->
                <div class="wd-full tempo">
                    <div class="wg-show-more">
                        <p>Showing 13 of 26 products</p>
                        <a href="#" class="tf-btn fw-medium">
                            LOAD MORE
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Product -->

<!-- Icon Box -->
<div class="flat-spacing-8 bg-main">
    <div class="container">
        <div class="tf-swiper swiper sw-iconbox" data-preview="4" data-tablet="3" data-mobile-sm="2" data-mobile="1" data-space-lg="80"
            data-space-md="30" data-space="15" data-pagination="1" data-pagination-sm="2" data-pagination-md="3" data-pagination-lg="4">
            <div class="swiper-wrapper">
                <!-- item 1 -->
                <div class="swiper-slide">
                    <div class="box_icon--V01 style-white wow fadeInLeft">
                        <span class="icon">
                            <i class="icon-box text-primary"></i>
                        </span>
                        <div class="content">
                            <h4 class="title">Free Shipping</h4>
                            <p class="text">Enjoy free shipping on all orders</p>
                        </div>
                    </div>
                </div>
                <!-- item 2 -->
                <div class="swiper-slide">
                    <div class="box_icon--V01 style-white wow fadeInLeft" data-wow-delay="0.1s">
                        <span class="icon">
                            <i class="icon-credit-card text-primary"></i>
                        </span>
                        <div class="content">
                            <h4 class="title">Flexible Payment</h4>
                            <p class="text">Pay with Multiple Credit Cards</p>
                        </div>
                    </div>
                </div>
                <!-- item 3 -->
                <div class="swiper-slide">
                    <div class="box_icon--V01 style-white wow fadeInLeft" data-wow-delay="0.2s">
                        <span class="icon">
                            <i class="icon-return text-primary"></i>
                        </span>
                        <div class="content">
                            <h4 class="title">14 - Days Return</h4>
                            <p class="text">Free return/exchange within 30 days</p>
                        </div>
                    </div>
                </div>
                <!-- item 4 -->
                <div class="swiper-slide">
                    <div class="box_icon--V01 style-white wow fadeInLeft" data-wow-delay="0.3s">
                        <span class="icon">
                            <i class="icon-headphone text-primary"></i>
                        </span>
                        <div class="content">
                            <h4 class="title">Premium Support</h4>
                            <p class="text">Enjoy our premium support</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sw-dot-default style-white tf-sw-pagination"></div>
        </div>
    </div>
</div>
<!-- /Icon Box -->

        @endsection