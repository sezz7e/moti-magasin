@php $whatsapp = config('store.contact.whatsapp'); @endphp
<!-- Toolbar -->
<div class="tf-toolbar-bottom">
    <div class="toolbar-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <a href="{{ route('home') }}">
            <span class="toolbar-icon"><i class="icon icon-menu-home"></i></span>
            <span class="toolbar-label">Home</span>
        </a>
    </div>

    <div class="toolbar-item {{ request()->routeIs('shop', 'collection') ? 'active' : '' }}">
        <a href="{{ route('shop') }}">
            <span class="toolbar-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
            </span>
            <span class="toolbar-label">Shop</span>
        </a>
    </div>

    <div class="toolbar-item">
        <a href="#search" data-bs-toggle="offcanvas">
            <span class="toolbar-icon"><i class="icon icon-search-2"></i></span>
            <span class="toolbar-label">Search</span>
        </a>
    </div>

    @if($whatsapp)
        <div class="toolbar-item">
            <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener">
                <span class="toolbar-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 11.5a8.5 8.5 0 0 1-12.6 7.4L3 20l1.2-5A8.5 8.5 0 1 1 21 11.5z"/>
                    </svg>
                </span>
                <span class="toolbar-label">Chat</span>
            </a>
        </div>
    @endif

    <div class="toolbar-item">
        <a href="#shoppingCart" data-bs-toggle="offcanvas">
            <span class="toolbar-icon">
                <i class="icon icon-cart-2"></i>
                <span class="toolbar-count" data-cart-count>{{ \App\Support\Cart::count() }}</span>
            </span>
            <span class="toolbar-label">Cart</span>
        </a>
    </div>
</div>
<style>
    .tf-toolbar-bottom .toolbar-item.active .toolbar-label { font-weight: 600; }
</style>
<!-- /Toolbar -->