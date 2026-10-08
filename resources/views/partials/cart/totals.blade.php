@if($lines->isNotEmpty())
    <div class="tf-cart-totals-discounts">
        <h6 class="tf-cart-total-text fw-normal text-uppercase">subtotal:</h6>
        <div class="tf-totals-total-value h6 fw-normal">PKR {{ number_format($total) }}</div>
    </div>
    <p class="text-caption text-main-4 mb-3">Shipping is calculated at checkout.</p>
    <div class="tf-mini-cart-view-checkout">
        <a href="{{ route('cart') }}" class="tf-btn w-100 style-2"><span class="fw-medium">GO TO CART</span></a>
        <a href="{{ route('checkout') }}" class="tf-btn btn-fill animate-btn w-100"><span class="fw-medium">CHECKOUT</span></a>
    </div>
@endif