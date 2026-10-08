@php
    $lines = \App\Support\Cart::lines();
    $total = \App\Support\Cart::total();
@endphp
<div class="offcanvas offcanvas-end popup-shopping-cart" id="shoppingCart">
    <div class="canvas-wrapper">
        <div class="canvas-header">
            <h3 class="title fw-normal text-uppercase">shopping cart</h3>
            <span class="icon-close link icon-close-popup" data-bs-dismiss="offcanvas"></span>
        </div>
        <div class="wrap">
            <div class="tf-mini-cart-threshold" data-cart-threshold>@include('partials.cart.threshold')</div>
            <div class="tf-mini-cart-wrap">
                <div class="tf-mini-cart-main">
                    <div class="tf-mini-cart-sroll" data-cart-items>@include('partials.cart.items')</div>
                </div>
                <div class="tf-mini-cart-bottom">
                    <div class="tf-mini-cart-tool">
                        <div class="tf-mini-cart-tool-btn btn-add-note">
                            <i class="icon icon-note"></i>
                            <p class="text-caption">Order note</p>
                        </div>
                    </div>
                    <div class="tf-mini-cart-bottom-wrap" data-cart-totals>@include('partials.cart.totals')</div>
                </div>
                <div class="tf-mini-cart-tool-openable add-note">
                    <div class="overlay tf-mini-cart-tool-close"></div>
                    <form action="{{ route('cart.note') }}" data-cart-note class="tf-mini-cart-tool-content style-border">
                        <label for="Cart-note" class="tf-mini-cart-tool-text h5 fw-normal text-uppercase">Order note</label>
                        <textarea name="note" id="Cart-note" placeholder="Instruction for seller..." class="d-flex">{{ session('cart_note') }}</textarea>
                        <div class="tf-cart-tool-btns">
                            <button class="subscribe-button tf-btn w-100 btn-fill animate-btn" type="submit">Save</button>
                            <button type="button" class="tf-btn style-2 w-100 tf-mini-cart-tool-close">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>