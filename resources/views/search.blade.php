@extends('layouts.app')

@section('content')
<section class="flat-spacing-3">
    <div class="container">
        <form action="{{ route('search') }}" method="GET" class="d-flex gap-2 mb-5" style="max-width:560px;">
            <input type="search" name="q" value="{{ $q }}" class="form-control" placeholder="Search for jewellery..." required minlength="2">
            <button type="submit" class="tf-btn btn-fill animate-btn"><span class="fw-medium">SEARCH</span></button>
        </form>

        @if($q === '' || mb_strlen($q) < 2)
            <p>Type at least 2 letters to search.</p>
        @elseif($products->isEmpty())
            <h3 class="fw-normal">No results for &ldquo;{{ $q }}&rdquo;</h3>
            <p class="mt-2">Try a different word, or <a href="{{ route('home') }}" class="link">browse the collections</a>.</p>
        @else
            <p class="mb-4">{{ $products->count() }} {{ \Illuminate\Support\Str::plural('result', $products->count()) }} for &ldquo;{{ $q }}&rdquo;</p>
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        @include('partials.product-card-theme')
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
