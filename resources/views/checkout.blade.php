@extends('layouts.app')

@section('content')
<section class="px-6 md:px-12 py-16 max-w-5xl mx-auto">
    <h1 class="font-serif text-5xl text-center">Checkout</h1>

    @error('cart')
        <p class="mt-8 text-burgundy text-center">{{ $message }}</p>
    @enderror

    <div class="grid md:grid-cols-2 gap-16 mt-12">
        <form method="POST" action="{{ route('checkout.store') }}" class="space-y-5">
            @csrf
            @foreach([
                ['customer_name', 'Full name', 'text'],
                ['phone', 'Mobile number (03XX XXXXXXX)', 'tel'],
                ['email', 'Email (optional)', 'email'],
                ['city', 'City', 'text'],
            ] as [$field, $label, $type])
                <div>
                    <label class="block text-sm mb-1">{{ $label }}</label>
                    <input type="{{ $type }}" name="{{ $field }}" value="{{ old($field) }}"
                           class="w-full border border-ink/20 bg-transparent px-3 py-2">
                    @error($field)<p class="text-sm text-burgundy mt-1">{{ $message }}</p>@enderror
                </div>
            @endforeach

            <div>
                <label class="block text-sm mb-1">Full address</label>
                <textarea name="address" rows="3" class="w-full border border-ink/20 bg-transparent px-3 py-2">{{ old('address') }}</textarea>
                @error('address')<p class="text-sm text-burgundy mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Notes (optional)</label>
                <textarea name="notes" rows="2" class="w-full border border-ink/20 bg-transparent px-3 py-2">{{ old('notes') }}</textarea>
            </div>

            <button class="w-full bg-ink text-ivory py-4 tracking-widest uppercase text-sm hover:bg-burgundy transition">
                Place order (Cash on delivery)
            </button>
        </form>

        <div>
            <h2 class="font-serif text-2xl mb-6">Order summary</h2>
            <div class="divide-y divide-ink/10">
                @foreach($lines as $line)
                    <div class="flex justify-between py-3 text-sm">
                        <span>{{ $line->product->name }} &times; {{ $line->qty }}</span>
                        <span>PKR {{ number_format($line->subtotal) }}</span>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 space-y-2 text-sm">
                <div class="flex justify-between"><span>Subtotal</span><span>PKR {{ number_format($subtotal) }}</span></div>
                <div class="flex justify-between"><span>Shipping</span><span>PKR {{ number_format($shipping) }}</span></div>
                <div class="flex justify-between font-serif text-xl pt-2 border-t border-ink/10">
                    <span>Total</span><span>PKR {{ number_format($total) }}</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection