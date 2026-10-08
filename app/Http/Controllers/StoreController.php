<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function home()
    {
        return view('home', [
            'collections' => Collection::orderBy('sort_order')->get(),
            'products' => Product::where('is_active', true)->latest()->take(8)->get(),
        ]);
    }

    public function collection(string $slug)
    {
        $collection = Collection::where('slug', $slug)->firstOrFail();

        return view('collection', [
            'collections' => Collection::with(['products' => fn ($q) => $q->where('is_active', true)->latest()])->orderBy('sort_order')->get(),
            'products' => $collection->products()->where('is_active', true)->latest()->get(),
        ]);
    }

    public function product(string $slug)
    {
        $product = Product::with('collection')->where('slug', $slug)->where('is_active', true)->firstOrFail();

        $related = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->when($product->collection_id, fn ($q) => $q->where('collection_id', $product->collection_id))
            ->latest()->take(8)->get();

        return view('product', compact('product', 'related'));
    }

    public function quickView(string $slug)
{
    $product = Product::with('collection')->where('slug', $slug)->where('is_active', true)->firstOrFail();

    return response()->json([
        'html' => view('partials.quick-view', compact('product'))->render(),
    ]);
}

public function search(Request $request)
{
    $q = trim((string) $request->query('q', ''));
    $products = collect();

    if (mb_strlen($q) >= 2) {
        $like = "%{$q}%";

        $products = Product::where('is_active', true)
            ->where(function ($w) use ($like) {
                $w->where('name', 'like', $like)
                  ->orWhere('description', 'like', $like)
                  ->orWhereHas('collection', fn ($c) => $c->where('name', 'like', $like));
            })
            ->latest()
            ->limit(48)
            ->get();
    }

    return view('search', compact('q', 'products'));
}

public function suggest(Request $request)
{
    $q = trim((string) $request->query('q', ''));

    if (mb_strlen($q) < 2) {
        return response()->json([]);
    }

    $items = Product::where('is_active', true)
        ->where('name', 'like', "%{$q}%")
        ->latest()
        ->take(6)
        ->get()
        ->map(fn ($p) => [
            'name' => $p->name,
            'price' => 'PKR ' . number_format($p->price),
            'url' => route('product', $p->slug),
            'image' => $p->getFirstMediaUrl('gallery', 'card'),
            'sold_out' => $p->stock < 1,
        ]);

    return response()->json($items);
}
}
