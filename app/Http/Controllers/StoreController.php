<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Product;

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
            'collection' => $collection,
            'products' => $collection->products()->where('is_active', true)->latest()->get(),
        ]);
    }

    public function product(string $slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('product', compact('product'));
    }
}