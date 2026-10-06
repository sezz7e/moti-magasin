@extends('layouts.app')

@section('content')
<section class="px-6 md:px-12 py-16 text-center">
    <h1 class="font-serif text-5xl">{{ $collection->name }}</h1>
    <p class="mt-4 text-ink/60 max-w-xl mx-auto">{{ $collection->description }}</p>
</section>

<section class="px-6 md:px-12 grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-10">
    @foreach($products as $product)
        @include('partials.product-card')
    @endforeach
</section>
@endsection