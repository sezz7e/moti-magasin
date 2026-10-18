<?php

namespace App\Support;

use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopFilters
{
    public const SORTS = [
        'best-selling' => 'Best selling',
        'a-z' => 'Alphabetically, A-Z',
        'z-a' => 'Alphabetically, Z-A',
        'price-low-high' => 'Price, low to high',
        'price-high-low' => 'Price, high to low',
    ];

    public static function run(Request $request, ?Collection $collection): array
    {
        $metalList = array_map('strval', config('store.metals', []));
        $stoneMap = config('store.stone_colors', []);
        $stoneList = array_map('strval', array_keys($stoneMap));
        $sizeList = array_map('strval', config('store.sizes', []));
        $thresholds = array_values(config('store.price_filters', []));
        $allCollections = Collection::orderBy('sort_order')->get(['id', 'name', 'slug']);

        // ---------- 1. Read and sanitise what the visitor asked for
        $pick = function (string $key, array $allowed) use ($request) {
            $given = array_filter((array) $request->query($key, []), 'is_string');

            return array_values(array_intersect($given, $allowed));
        };
        $one = function (string $key, array $allowed) use ($request) {
            $v = $request->query($key);

            return is_string($v) && in_array($v, $allowed, true) ? $v : null;
        };

        $priceDefs = [];
        foreach ($thresholds as $t) {
            $priceDefs['under-' . $t] = [
                'label' => 'Under PKR ' . number_format($t),
                'test' => fn ($p) => $p->price <= $t,
            ];
        }
        if ($thresholds) {
            $top = end($thresholds);
            $priceDefs['over-' . $top] = [
                'label' => 'Over PKR ' . number_format($top),
                'test' => fn ($p) => $p->price > $top,
            ];
        }

        $filters = [
            'stock' => $one('stock', ['in', 'out']),
            'collections' => $collection ? [] : $pick('collection', $allCollections->pluck('slug')->all()),
            'metals' => $pick('metal', $metalList),
            'stones' => $pick('stone', $stoneList),
            'sizes' => $pick('size', $sizeList),
            'price' => $one('price_range', array_keys($priceDefs)),
            'sort' => $one('sort', array_keys(self::SORTS)) ?? 'best-selling',
        ];

        // ---------- 2. Counts shown next to each option (whole scope, ignoring other filters)
        $base = Product::where('is_active', true)
            ->when($collection, fn ($q) => $q->where('collection_id', $collection->id))
            ->get(['id', 'collection_id', 'price', 'stock', 'metals', 'stone_colors', 'sizes']);

        $has = fn (string $attr, string $value) => $base->filter(
            fn ($p) => in_array($value, array_map('strval', $p->{$attr} ?? []), true)
        )->count();

        $byCollection = $base->groupBy('collection_id')->map(fn ($g) => $g->count());

        $facets = [
            'stock' => [
                'in' => ['label' => 'In Stock', 'count' => $base->where('stock', '>', 0)->count()],
                'out' => ['label' => 'Out of Stock', 'count' => $base->where('stock', '<=', 0)->count()],
            ],
            'categories' => $allCollections->mapWithKeys(fn ($c) => [
                $c->slug => ['label' => $c->name, 'count' => $byCollection[$c->id] ?? 0],
            ])->all(),
            'metals' => collect($metalList)->mapWithKeys(fn ($m) => [
                $m => ['label' => $m, 'count' => $has('metals', $m)],
            ])->all(),
            'stones' => collect($stoneList)->mapWithKeys(fn ($s) => [
                $s => ['label' => $s, 'color' => $stoneMap[$s] ?? '#ccc', 'count' => $has('stone_colors', $s)],
            ])->all(),
            'sizes' => collect($sizeList)->mapWithKeys(fn ($s) => [
                $s => ['label' => $s, 'count' => $has('sizes', $s)],
            ])->all(),
            'prices' => collect($priceDefs)->map(fn ($d) => [
                'label' => $d['label'],
                'count' => $base->filter($d['test'])->count(),
            ])->all(),
        ];

        // ---------- 3. Apply the filters
        $query = Product::query()
            ->with('media')
            ->where('is_active', true)
            ->when($collection, fn ($q) => $q->where('collection_id', $collection->id))
            ->when($filters['collections'], fn ($q, $slugs) => $q->whereHas('collection', fn ($c) => $c->whereIn('slug', $slugs)))
            ->when($filters['stock'] === 'in', fn ($q) => $q->where('stock', '>', 0))
            ->when($filters['stock'] === 'out', fn ($q) => $q->where('stock', '<=', 0));

        foreach (['metals' => 'metals', 'stones' => 'stone_colors', 'sizes' => 'sizes'] as $key => $column) {
            $values = $filters[$key];

            if (! $values) {
                continue;
            }

            // Within one filter the choices are "or" (Gold or Silver); between filters they are "and"
            $query->where(function ($w) use ($column, $values) {
                foreach ($values as $v) {
                    $w->orWhereJsonContains($column, $v);

                    if (is_numeric($v)) {
                        $w->orWhereJsonContains($column, (int) $v);
                    }
                }
            });
        }

        if ($filters['price']) {
            [$kind, $amount] = explode('-', $filters['price']);

            if ($kind === 'under') {
                $query->where('price', '<=', (int) $amount);
            } else {
                $query->where('price', '>', (int) $amount);
            }
        }

        match ($filters['sort']) {
            'a-z' => $query->orderBy('name'),
            'z-a' => $query->orderByDesc('name'),
            'price-low-high' => $query->orderBy('price'),
            'price-high-low' => $query->orderByDesc('price'),
            default => $query
                ->withSum(['orderItems as sold' => fn ($q) => $q->whereHas('order', fn ($o) => $o->where('status', '!=', 'cancelled'))], 'quantity')
                ->orderByDesc('sold')
                ->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        // ---------- 4. Applied-filter chips, each one removes just that choice
        $urlWithout = function (string $key, ?string $value = null) use ($request) {
            $q = $request->query();
            unset($q['page']);

            if ($value === null) {
                unset($q[$key]);
            } else {
                $left = array_values(array_diff((array) ($q[$key] ?? []), [$value]));

                if ($left) {
                    $q[$key] = $left;
                } else {
                    unset($q[$key]);
                }
            }

            return url()->current() . ($q ? '?' . http_build_query($q) : '') . '#shop-grid';
        };

        $chips = [];
        if ($filters['stock']) {
            $chips[] = ['label' => $facets['stock'][$filters['stock']]['label'], 'url' => $urlWithout('stock')];
        }
        foreach ($filters['collections'] as $s) {
            $chips[] = ['label' => $facets['categories'][$s]['label'], 'url' => $urlWithout('collection', $s)];
        }
        foreach ($filters['metals'] as $m) {
            $chips[] = ['label' => $m, 'url' => $urlWithout('metal', $m)];
        }
        foreach ($filters['stones'] as $s) {
            $chips[] = ['label' => $s, 'url' => $urlWithout('stone', $s)];
        }
        foreach ($filters['sizes'] as $s) {
            $chips[] = ['label' => 'Size ' . $s, 'url' => $urlWithout('size', $s)];
        }
        if ($filters['price']) {
            $chips[] = ['label' => $facets['prices'][$filters['price']]['label'], 'url' => $urlWithout('price_range')];
        }

        $sortUrl = function (string $key) use ($request) {
            $q = $request->query();
            unset($q['page']);
            $q['sort'] = $key;

            return url()->current() . '?' . http_build_query($q) . '#shop-grid';
        };

        return [
            'products' => $products,
            'filters' => $filters,
            'facets' => $facets,
            'chips' => $chips,
            'sorts' => self::SORTS,
            'sortUrl' => $sortUrl,
            'clearUrl' => url()->current() . '#shop-grid',
        ];
    }
}