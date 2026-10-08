@php
    $searchCollections = \App\Models\Collection::orderBy('sort_order')->get();
    $searchPicks = \App\Models\Product::where('is_active', true)->latest()->take(3)->get();
@endphp
<!-- Search -->
<div class="offcanvas offcanvas-top offcanvas-search" id="search">
    <div class="offcanvas-content">
        <div class="container">
            <div class="popup-content">
                <form class="form-search" action="{{ route('search') }}" method="GET">
                    <fieldset>
                        <input type="text" placeholder="ENTER YOUR SEARCH" name="q" tabindex="0" autocomplete="off"
                               aria-required="true" required minlength="2" data-search-input
                               data-suggest-url="{{ route('search.suggest') }}"
                               data-placeholder="{{ asset('images/products/product-6.jpg') }}">
                    </fieldset>
                    <button type="submit" class="link"><i class="icon icon-search"></i></button>
                    <span class="icon-close-popup" data-bs-dismiss="offcanvas">
                        <i class="icon-close"></i>
                    </span>
                </form>
                <div class="tf-grid-layout sm-col-2">
                    <div class="feature-wrap">
                        <p class="title">QUICK LINK</p>
                        <ul class="quick-link-list">
                            @foreach($searchCollections as $c)
                                <li><a href="{{ route('collection', $c->slug) }}" class="link-item text-main-4 link">{{ $c->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="feature-wrap">
                        <p class="title" data-search-title>SUGGESTION FOR YOU</p>
                        <ul class="product-list" data-search-list>
                            @foreach($searchPicks as $p)
                                @php $onSale = $p->compare_at_price && $p->compare_at_price > $p->price; @endphp
                                <li>
                                    <div class="tf-product-mini-view">
                                        <a href="{{ route('product', $p->slug) }}" class="prd-image">
                                            <img src="{{ $p->getFirstMediaUrl('gallery', 'card') ?: asset('images/products/product-6.jpg') }}" alt="">
                                        </a>
                                        <div class="prd-content">
                                            <a href="{{ route('product', $p->slug) }}" class="prd-name link text-uppercase">{{ $p->name }}</a>
                                            <div class="price-wrap">
                                                @if($p->stock > 0)
                                                    <span class="price-new {{ $onSale ? 'price-on-sale' : '' }}">PKR {{ number_format($p->price) }}</span>
                                                    @if($onSale)
                                                        <span class="price-old compare-at-price text-caption">PKR {{ number_format($p->compare_at_price) }}</span>
                                                    @endif
                                                @else
                                                    <span class="text-caption">Sold out</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <span class="close" data-bs-dismiss="offcanvas"></span>
</div>
<!-- /Search -->