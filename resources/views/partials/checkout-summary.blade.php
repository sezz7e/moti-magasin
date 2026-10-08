<ul class="sum-items">
    @foreach($lines as $line)
        <li>
            <div class="thumb">
                <img src="{{ $line->product->getFirstMediaUrl('gallery', 'card') ?: asset('images/products/product-6.jpg') }}" alt="">
                <span class="badge">{{ $line->qty }}</span>
            </div>
            <div class="grow">{{ $line->product->name }}</div>
            <div>PKR {{ number_format($line->subtotal) }}</div>
        </li>
    @endforeach
</ul>
<dl class="sum-rows">
    <div><dt>Subtotal</dt><dd>PKR {{ number_format($subtotal) }}</dd></div>
    <div><dt>Shipping</dt><dd>{{ $shipping > 0 ? 'PKR ' . number_format($shipping) : 'Free' }}</dd></div>
</dl>
<div class="sum-total"><span>Total</span><span><small>PKR</small>{{ number_format($total) }}</span></div>