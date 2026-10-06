@extends('layouts.app')

@section('content')
<section class="px-6 md:px-12 py-12 grid md:grid-cols-2 gap-12">
    <div class="space-y-4">
        @foreach($product->getMedia('gallery') as $image)
            <img src="{{ $image->getUrl('large') }}" alt="{{ $product->name }}" class="w-full">
        @endforeach
    </div>

    <div class="md:sticky md:top-12 self-start">
        <h1 class="font-serif text-4xl md:text-5xl">{{ $product->name }}</h1>
        <p class="mt-4 text-xl">PKR {{ number_format($product->price) }}</p>
        <p class="mt-8 text-ink/70 leading-relaxed">{{ $product->description }}</p>
        @if($product->stock > 0)
            <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-10">
                @csrf
                <button class="bg-ink text-ivory px-10 py-4 tracking-widest uppercase text-sm hover:bg-burgundy transition">
                    Add to cart
                </button>
            </form>
            <p class="mt-4 text-sm text-ink/50">{{ $product->stock }} available</p>
        @else
            <p class="mt-10 text-sm uppercase tracking-widest text-burgundy">Sold out</p>
        @endif
    </div>
</section>
@endsection