@extends('layouts.app')

@section('content')
@php $title = $collection->name ?? 'All jewellery'; @endphp

<!-- Page Title -->
<section class="flat-spacing-2 pb-0">
    <div class="container">
        <div class="page-title type-2">
            <div class="breadcrumbs">
                <ul class="bread-wrap">
                    <li><a href="{{ route('home') }}" class="text-main-4 link-secondary">Home</a></li>
                    <li class="br-line w-12 bg-main"></li>
                    <li>
                        <p>{{ $title }}</p>
                    </li>
                </ul>
                <h1 class="heading fw-normal text-uppercase">
                    {{ $title }}
                    <span class="number-count">
                        {{ $products->total() }}
                    </span>
                </h1>
            </div>
            <div class="box-text">
                <p class="text-main-4">
                    Discover our rings collection to find the latest addition to your jewellery box. From crown, heart and flower rings
                    adorned with clear crystals to simple beaded and wishbone styles, our rings for women collection has it all. Refine
                    your style with a  sterling silver,  14k gold-plated, 14k rose gold-plated or 14k gold ring.
                </p>
            </div>
        </div>
    </div>
</section>
<!-- /Page Title -->

<div class="flat-spacing-3">
    <div class="container">
        <form id="shop-filter-form" method="GET" action="{{ url()->current() }}#shop-grid">
            @if($filters['sort'] !== 'best-selling')
                <input type="hidden" name="sort" value="{{ $filters['sort'] }}">
            @endif

            <div class="tf-shop-control">
                <div class="tf-control-filter">
                    <div class="tf-filter-dropdown">
                        <p class="title-filter h5"><span class="text">FILTER</span></p>
                        <div class="meta-dropdown-filter">
                            @include('partials.shop-filter-dropdown', [
                                'id' => 'availability', 'label' => 'availability', 'name' => 'stock', 'type' => 'radio',
                                'options' => $facets['stock'], 'selected' => array_filter([$filters['stock']]),
                            ])

                            @unless($collection)
                                @include('partials.shop-filter-dropdown', [
                                    'id' => 'category', 'label' => 'category', 'name' => 'collection', 'type' => 'checkbox',
                                    'options' => $facets['categories'], 'selected' => $filters['collections'],
                                ])
                            @endunless

                            @include('partials.shop-filter-dropdown', [
                                'id' => 'metal', 'label' => 'metal color', 'name' => 'metal', 'type' => 'checkbox',
                                'options' => $facets['metals'], 'selected' => $filters['metals'],
                            ])

                            @include('partials.shop-filter-dropdown', [
                                'id' => 'stone', 'label' => 'stone colour', 'name' => 'stone', 'type' => 'checkbox',
                                'options' => $facets['stones'], 'selected' => $filters['stones'],
                            ])

                            @include('partials.shop-filter-dropdown', [
                                'id' => 'price', 'label' => 'price', 'name' => 'price_range', 'type' => 'radio',
                                'options' => $facets['prices'], 'selected' => array_filter([$filters['price']]),
                            ])

                            <div class="dropdown dropdown-filter">
                                <div class="dropdown-toggle" id="f-size" data-bs-toggle="dropdown" aria-expanded="false"
                                     data-bs-auto-close="outside" role="button">
                                    <span class="text-uppercase">size</span>
                                    <span class="icon icon-arrow-angle-down"></span>
                                </div>
                                <div class="dropdown-menu" aria-labelledby="f-size">
                                    <div class="filter-size-box flat-check-list">
                                        @foreach($facets['sizes'] as $value => $opt)
                                            @php
                                                $checked = in_array((string) $value, $filters['sizes'], true);
                                                $off = $opt['count'] === 0 && ! $checked;
                                            @endphp
                                            <label class="check-item size-item size-check {{ $checked ? 'active' : '' }} {{ $off ? 'disabled' : '' }}" data-size-toggle>
                                                <input type="checkbox" name="size[]" value="{{ $value }}" class="d-none" @checked($checked) @disabled($off)>
                                                <span class="count size">{{ $opt['label'] }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tf-group-layout type-drop">
                    <ul class="tf-control-layout">
                        <li class="tf-view-layout-switch sw-layout-2 d-none d-md-flex" data-value-layout="tf-col-2">
                            <div class="item icon-grid-2"><span></span><span></span></div>
                        </li>
                        <li class="tf-view-layout-switch sw-layout-3 d-none d-md-flex" data-value-layout="tf-col-3">
                            <div class="item icon-grid-3"><span></span><span></span><span></span></div>
                        </li>
                        <li class="tf-view-layout-switch sw-layout-4 active d-none d-xl-flex" data-value-layout="tf-col-4">
                            <div class="item icon-grid-4"><span></span><span></span><span></span><span></span></div>
                        </li>
                    </ul>
                    <div class="tf-dropdown-sort" data-bs-toggle="dropdown">
                        <div class="btn-select">
                            <span class="text-sort-value">{{ $sorts[$filters['sort']] }}</span>
                            <span class="icon icon-arrow-angle-down"></span>
                        </div>
                        <div class="dropdown-menu">
                            @foreach($sorts as $key => $label)
                                <div class="select-item {{ $filters['sort'] === $key ? 'active' : '' }}" data-sort-href="{{ $sortUrl($key) }}">
                                    <span class="text-value-item">{{ $label }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <noscript><button type="submit" class="tf-btn btn-fill mt-3"><span class="fw-medium">APPLY FILTERS</span></button></noscript>
        </form>

        <div id="shop-results">
            @if($chips)
                <div class="d-flex flex-wrap align-items-center gap-2 my-4">
                    @foreach($chips as $chip)
                        <a href="{{ $chip['url'] }}" class="shop-chip" data-ajax-nav>{{ $chip['label'] }} &times;</a>
                    @endforeach
                    <a href="{{ $clearUrl }}" class="tf-btn-line" data-ajax-nav><span class="text-body">Clear all</span></a>
                </div>
            @endif

            <div class="wrapper-control-shop gridLayout-wrapper mt-4" id="shop-grid">
                <div class="wrapper-shop tf-grid-layout tf-col-4" id="gridLayout">
                    @forelse($products as $product)
                        @include('partials.product-card-theme', ['gridClass' => 'grid', 'gridItem' => true])
                    @empty
                        <div class="wd-full tempo text-center py-5">
                            <h3 class="fw-normal">No pieces match these filters</h3>
                            <a href="{{ $clearUrl }}" class="tf-btn-line mt-3 d-inline-block" data-ajax-nav><span class="text-body">Clear all filters</span></a>
                        </div>
                    @endforelse

                    @if($products->total() > 0)
                        <div class="wd-full tempo" data-load-more-wrap>
                            <div class="wg-show-more">
                                <p>Showing {{ $products->lastItem() }} of {{ $products->total() }} {{ \Illuminate\Support\Str::plural('product', $products->total()) }}</p>
                                @if($products->hasMorePages())
                                    <a href="{{ $products->nextPageUrl() }}" class="tf-btn fw-medium" data-load-more>LOAD MORE</a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .shop-chip { display: inline-block; padding: 4px 14px; border: 1px solid rgba(0, 0, 0, .25); border-radius: 999px; font-size: 13px; text-decoration: none; color: inherit; }
    .shop-chip:hover { border-color: currentColor; }
</style>

<script>
(function () {
    var form = document.getElementById('shop-filter-form');
    if (!form) return;

    var controller = null;

    function urlFromForm() {
        var qs = new URLSearchParams(new FormData(form)).toString();
        return window.location.pathname + (qs ? '?' + qs : '');
    }

    function syncControls(doc) {
        // Sort menu: refresh each item's link and highlight, and the label (updated in place so the dropdown keeps working)
        var fresh = doc.querySelectorAll('[data-sort-href]');
        document.querySelectorAll('[data-sort-href]').forEach(function (el, i) {
            if (fresh[i]) {
                el.dataset.sortHref = fresh[i].dataset.sortHref;
                el.className = fresh[i].className;
            }
        });
        var label = document.querySelector('.text-sort-value');
        var freshLabel = doc.querySelector('.text-sort-value');
        if (label && freshLabel) label.textContent = freshLabel.textContent;

        // Hidden sort field
        var cur = form.querySelector('input[name="sort"]');
        var freshInput = doc.querySelector('#shop-filter-form input[name="sort"]');
        if (freshInput) {
            if (!cur) {
                cur = document.createElement('input');
                cur.type = 'hidden';
                cur.name = 'sort';
                form.prepend(cur);
            }
            cur.value = freshInput.value;
        } else if (cur) {
            cur.remove();
        }

        // Checked and disabled state of every filter option
        form.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(function (input) {
            var match = Array.prototype.find.call(
                doc.querySelectorAll('#shop-filter-form input[name="' + input.name + '"]'),
                function (f) { return f.value === input.value; }
            );
            input.checked = !!(match && match.checked);
            if (match) input.disabled = match.disabled;

            var item = input.closest('li.list-item');
            if (item && match) item.classList.toggle('disabled', match.disabled);

            var size = input.closest('label[data-size-toggle]');
            if (size) {
                size.classList.toggle('active', input.checked);
                if (match) size.classList.toggle('disabled', match.disabled);
            }
        });
    }

    async function load(url, push) {
        url = url.split('#')[0];
        var results = document.getElementById('shop-results');
        var mine = new AbortController();
        if (controller) controller.abort();
        controller = mine;

        results.style.opacity = '.5';
        results.setAttribute('aria-busy', 'true');

        try {
            var res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }, signal: mine.signal });
            if (!res.ok) throw new Error('bad response');

            var doc = new DOMParser().parseFromString(await res.text(), 'text/html');
            var fresh = doc.getElementById('shop-results');
            if (!fresh) throw new Error('no results block');

            // Remember the column layout the visitor picked (2, 3 or 4)
            var oldGrid = document.getElementById('gridLayout');
            var cols = oldGrid && Array.prototype.find.call(oldGrid.classList, function (c) { return /^tf-col-\d$/.test(c); });

            results.innerHTML = fresh.innerHTML;

            var grid = document.getElementById('gridLayout');
            if (grid && cols) {
                Array.prototype.filter.call(grid.classList, function (c) { return /^tf-col-\d$/.test(c); })
                    .forEach(function (c) { grid.classList.remove(c); });
                grid.classList.add(cols);
            }

            syncControls(doc);

            if (push !== false) history.pushState({ shop: true }, '', url);
        } catch (err) {
            if (err.name === 'AbortError') return;
            window.location.href = url; // fall back to a normal page load
        } finally {
            if (controller === mine) {
                results.style.opacity = '';
                results.removeAttribute('aria-busy');
            }
        }
    }

    // Any checkbox or radio change applies the filters without a reload
    form.addEventListener('submit', function (e) { e.preventDefault(); load(urlFromForm()); });
    form.addEventListener('change', function () { form.requestSubmit ? form.requestSubmit() : form.submit(); });

    // Back and forward buttons
    window.addEventListener('popstate', function () { load(window.location.href, false); });

    // Capture phase, so these run before the theme's own demo filter scripts
    document.addEventListener('click', async function (e) {
        var nav = e.target.closest('[data-ajax-nav]');
        if (nav) {
            e.preventDefault(); e.stopPropagation();
            load(nav.href);
            return;
        }

        var sort = e.target.closest('[data-sort-href]');
        if (sort) {
            e.preventDefault(); e.stopPropagation();
            load(sort.dataset.sortHref);
            return;
        }

        var size = e.target.closest('label[data-size-toggle]');
        if (size) {
            e.preventDefault(); e.stopPropagation();
            var input = size.querySelector('input');
            if (input && !input.disabled) {
                input.checked = !input.checked;
                size.classList.toggle('active', input.checked);
                form.requestSubmit ? form.requestSubmit() : form.submit();
            }
            return;
        }

        var more = e.target.closest('[data-load-more]');
        if (more) {
            e.preventDefault(); e.stopPropagation();
            more.textContent = 'LOADING…';
            try {
                var res = await fetch(more.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                var doc = new DOMParser().parseFromString(await res.text(), 'text/html');
                var grid = document.getElementById('gridLayout');
                var wrap = grid.querySelector('[data-load-more-wrap]');

                doc.querySelectorAll('#gridLayout [data-grid-item]').forEach(function (node) {
                    grid.insertBefore(document.importNode(node, true), wrap);
                });

                var freshWrap = doc.querySelector('#gridLayout [data-load-more-wrap]');
                if (freshWrap) wrap.innerHTML = freshWrap.innerHTML;
            } catch (err) {
                window.location.href = more.href;
            }
        }
    }, true);
})();
</script>
@endsection