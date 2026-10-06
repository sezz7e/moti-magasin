<a href="{{ route('product', $product->slug) }}" class="group block">
    <div class="aspect-[4/5] bg-ink/5 overflow-hidden">
        @if($product->getFirstMediaUrl('gallery'))
            <img src="{{ $product->getFirstMediaUrl('gallery', 'card') }}" alt="{{ $product->name }}"
                 class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
        @endif
    </div>
    <h3 class="font-serif text-xl mt-4">{{ $product->name }}</h3>
    <p class="text-sm text-ink/60">PKR {{ number_format($product->price) }}</p>
</a>