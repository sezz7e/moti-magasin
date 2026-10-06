@extends('layouts.app')

@section('content')
<section class="px-6 md:px-12 py-28 text-center">
    <p class="text-xs tracking-[0.4em] uppercase text-gold">Handmade Desi Jewellery</p>
    <h1 class="font-serif text-5xl md:text-7xl mt-6">Beads, threaded<br>with heritage.</h1>
</section>

<section id="collections" class="px-6 md:px-12">
    <div class="flex flex-wrap gap-8 justify-center mb-16">
        @foreach($collections as $c)
            <a href="{{ route('collection', $c->slug) }}" class="font-serif text-2xl hover:text-gold">{{ $c->name }}</a>
        @endforeach
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-10">
        @foreach($products as $product)
            @include('partials.product-card')
        @endforeach
    </div>
</section>
@endsection