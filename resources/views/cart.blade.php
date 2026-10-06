@extends('layouts.app')

@section('content')
<section class="px-6 md:px-12 py-16 max-w-4xl mx-auto">
    <h1 class="font-serif text-5xl text-center">Your Cart</h1>

    @if($lines->isEmpty())
        <p class="text-center mt-12 text-ink/60">Your cart is empty.</p>
        <p class="text-center mt-6"><a href="{{ route('home') }}" class="underline hover:text-gold">Continue shopping</a></p>
    @else
        <div class="mt-12 divide-y divide-ink/10">
            @foreach($lines as $line)
                <div class="flex items-center gap-6 py-6">
                    <div class="w-24 aspect-[4/5] bg-ink/5 overflow-hidden shrink-0">
                        @if($line->product->getFirstMediaUrl('gallery'))
                            <img src="{{ $line->product->getFirstMediaUrl('gallery', 'card') }}" class="w-full h-full object-cover" alt="">
                        @endif
                    </div>

                    <div class="flex-1">
                        <a href="{{ route('product', $line->product->slug) }}" class="font-serif text-xl hover:text-gold">{{ $line->product->name }}</a>
                        <p class="text-sm text-ink/60">PKR {{ number_format($line->product->price) }}</p>

                        <form method="POST" action="{{ route('cart.update', $line->product) }}" class="mt-3 flex items-center gap-2">
                            @csrf @method('PATCH')
                            <input type="number" name="qty" value="{{ $line->qty }}" min="1" max="{{ $line->product->stock }}"
                                   class="w-16 border border-ink/20 bg-transparent px-2 py-1 text-sm">
                            <button class="text-sm underline hover:text-gold">Update</button>
                        </form>
                    </div>

                    <div class="text-right">
                        <p>PKR {{ number_format($line->subtotal) }}</p>
                        <form method="POST" action="{{ route('cart.remove', $line->product) }}" class="mt-2">
                            @csrf @method('DELETE')
                            <button class="text-xs text-ink/50 underline hover:text-burgundy">Remove</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-between items-center mt-10 border-t border-ink/10 pt-8">
            <span class="font-serif text-2xl">Total</span>
            <span class="text-xl">PKR {{ number_format($total) }}</span>
        </div>

        <p class="text-sm text-ink/50 mt-2 text-right">Cash on delivery. Shipping is calculated at checkout.</p>

        <div class="mt-8 text-right">
            <span class="inline-block bg-ink/20 text-ink/50 px-10 py-4 tracking-widest uppercase text-sm">Checkout (next step)</span>
        </div>
    @endif
</section>
@endsection