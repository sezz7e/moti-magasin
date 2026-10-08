@php
    $navCollections = \App\Models\Collection::orderBy('sort_order')->get();
    $contact = config('store.contact');
@endphp
<!-- Mobile Menu -->
<div class="offcanvas offcanvas-start canvas-mb" id="mobileMenu">
    <span class="icon-close-popup" data-bs-dismiss="offcanvas">
        <i class="icon-close"></i>
    </span>
    <div class="mb-canvas-content">
        <div class="mb-body">
            <div class="mb-content-top">
                <ul class="nav-ul-mb" id="wrapper-menu-navigation">
                    <li class="nav-mb-item">
                        <a href="{{ route('home') }}" class="mb-menu-link"><span>Home</span></a>
                    </li>

                    @if($navCollections->isNotEmpty())
                        <li class="nav-mb-item">
                            <a href="#dropdown-menu-collections" class="collapsed mb-menu-link" data-bs-toggle="collapse"
                               aria-expanded="false" aria-controls="dropdown-menu-collections">
                                <span>Collections</span>
                                <span class="btn-open-sub"></span>
                            </a>
                            <div id="dropdown-menu-collections" class="collapse">
                                <ul class="sub-nav-menu">
                                    @foreach($navCollections as $c)
                                        <li><a href="{{ route('collection', $c->slug) }}" class="sub-nav-link">{{ $c->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif

                    <li class="nav-mb-item">
                        <a href="{{ route('cart') }}" class="mb-menu-link" data-open-cart>
                            <span>Cart (<span data-cart-count>{{ \App\Support\Cart::count() }}</span>)</span>
                        </a>
                    </li>
                </ul>
            </div>

            @if(array_filter($contact ?? []))
                <div class="mb-other-content">
                    @if(!empty($contact['whatsapp']))
                        <div class="mb-notice">
                            <a href="https://wa.me/{{ $contact['whatsapp'] }}" target="_blank" rel="noopener" class="text-need">Need help? Chat on WhatsApp</a>
                        </div>
                    @endif
                    <ul class="mb-info">
                        @if(!empty($contact['instagram']))
                            <li>Instagram: <a href="{{ $contact['instagram'] }}" target="_blank" rel="noopener" class="fw-medium">Follow us</a></li>
                        @endif
                        @if(!empty($contact['email']))
                            <li>Email: <a href="mailto:{{ $contact['email'] }}" class="fw-medium">{{ $contact['email'] }}</a></li>
                        @endif
                        @if(!empty($contact['phone']))
                            <li>Phone: <a href="tel:{{ preg_replace('/\s+/', '', $contact['phone']) }}" class="fw-medium">{{ $contact['phone'] }}</a></li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- /Mobile Menu -->