<ul class="sum-items">
    @foreach($order->items as $item)
        @php $img = $item->product?->getFirstMediaUrl('gallery', 'card'); @endphp
        <li>
            <div class="thumb">
                @if($img)<img src="{{ $img }}" alt="">@endif
                <span class="badge">{{ $item->quantity }}</span>
            </div>
            <div class="grow">{{ $item->product_name }}</div>
            <div>PKR {{ number_format($item->price * $item->quantity) }}</div>
        </li>
    @endforeach
</ul>
<dl class="sum-rows">
    <div><dt>Subtotal</dt><dd>PKR {{ number_format($order->subtotal) }}</dd></div>
    <div><dt>Shipping</dt><dd>{{ $order->shipping > 0 ? 'PKR ' . number_format($order->shipping) : 'Free' }}</dd></div>
</dl>
<div class="sum-total"><span>Total</span><span><small>PKR</small>{{ number_format($order->total) }}</span></div>