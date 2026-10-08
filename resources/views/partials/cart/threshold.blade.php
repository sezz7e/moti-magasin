@if($lines->isNotEmpty())
    @php $free = config('store.free_shipping_over'); @endphp
    @if($free)
        @php
            $remaining = max(0, $free - $total);
            $pct = min(100, (int) round($total / $free * 100));
        @endphp
        <h6 class="text fw-normal text-uppercase">
            @if($remaining > 0)
                Spend <span class="fw-medium">PKR {{ number_format($remaining) }}</span> more to get <span class="fw-medium">Free Shipping</span>
            @else
                You've unlocked <span class="fw-medium">Free Shipping</span>
            @endif
        </h6>
        <div class="tf-progress-bar tf-progress-ship">
            <div class="value" style="width: {{ $pct }}%;"><i class="icon icon-delivery"></i></div>
        </div>
    @endif
    <div class="tf-number-count">
        @php $qtyTotal = $lines->sum('qty'); @endphp
        <p class="text-uppercase"><span class="prd-count">{{ $qtyTotal }}</span> {{ \Illuminate\Support\Str::plural('product', $qtyTotal) }}</p>
        <a href="javascript:void(0)" class="tf-btn-line style-line-2" data-cart-clear data-url="{{ route('cart.clear') }}">
            <span class="text-body">Empty cart</span>
        </a>
    </div>
@endif