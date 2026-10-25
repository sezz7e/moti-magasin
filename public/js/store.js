(function () {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;
    const drawerEl = document.getElementById('shoppingCart');

    const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

    async function send(url, data = {}, method = 'POST') {
        const body = new FormData();
        Object.entries(data).forEach(([k, v]) => body.append(k, v));
        if (method !== 'POST') body.append('_method', method);

        const res = await fetch(url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body,
        });

        if (!res.ok) {
            const err = new Error('Request failed');
            err.status = res.status;
            try { err.data = await res.json(); } catch (e) { /* no body */ }
            throw err;
        }
        return res.json();
    }

    async function getJson(url) {
        const res = await fetch(url, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
        if (!res.ok) throw new Error('Request failed');
        return res.json();
    }

    function render(data) {
        const set = (sel, html) => document.querySelectorAll(sel).forEach((el) => (el.innerHTML = html));
        set('[data-cart-threshold]', data.threshold);
        set('[data-cart-items]', data.items);
        set('[data-cart-totals]', data.totals);
        document.querySelectorAll('[data-cart-count]').forEach((el) => (el.textContent = data.count));
    }

    function openDrawer() {
        if (!drawerEl || !window.bootstrap) return;

        const showCart = () => bootstrap.Offcanvas.getOrCreateInstance(drawerEl).show();
        const menu = document.getElementById('mobileMenu');
        const quick = document.getElementById('quickView');

        if (menu && menu.classList.contains('show')) {
            menu.addEventListener('hidden.bs.offcanvas', showCart, { once: true });
            bootstrap.Offcanvas.getOrCreateInstance(menu).hide();
            return;
        }
        if (quick && quick.classList.contains('show')) {
            quick.addEventListener('hidden.bs.modal', showCart, { once: true });
            bootstrap.Modal.getOrCreateInstance(quick).hide();
            return;
        }
        showCart();
    }

    function initQuickViewSlider() {
        const el = document.getElementById('qv-slider');
        if (!el || !window.Swiper) return;

        new Swiper(el, {
            observer: true,
            observeParents: true,
            navigation: {
                prevEl: el.querySelector('.single-slide-prev'),
                nextEl: el.querySelector('.single-slide-next'),
            },
        });
    }

    // A required option (metal / colour / size) that hasn't been chosen yet
    function missingOption(form) {
        const empty = Array.from(form.querySelectorAll('input[name^="options["]')).find((i) => !i.value);
        return empty ? 'Please choose a ' + (empty.dataset.label || 'option') + '.' : null;
    }

    function showFormError(form, message) {
        const box = form.querySelector('[data-option-error]');
        if (box) box.textContent = message;
        else alert(message);
    }

    // Release keyboard focus before a modal or offcanvas hides (avoids the aria-hidden warning)
    ['hide.bs.modal', 'hide.bs.offcanvas'].forEach((evt) => {
        document.addEventListener(evt, () => {
            if (document.activeElement instanceof HTMLElement) document.activeElement.blur();
        });
    });

    // ---------- Option pickers (capture phase, so the theme's own size-button script stays out of the way) ----------
    document.addEventListener('click', (e) => {
        const pick = e.target.closest('[data-option-pick]');
        if (!pick) return;

        const form = pick.closest('form');
        const group = pick.closest('[data-option-group]');
        if (!form || !group) return;

        e.preventDefault();
        e.stopPropagation();

        const name = group.dataset.optionGroup;
        group.querySelectorAll('[data-option-pick]').forEach((s) => s.classList.toggle('active', s === pick));
        form.querySelector('input[name="options[' + name + ']"]').value = pick.dataset.optionPick;

        const label = form.querySelector('[data-option-value="' + name + '"]');
        if (label) label.textContent = pick.dataset.optionPick;

        const box = form.querySelector('[data-option-error]');
        if (box) box.textContent = '';
    }, true);

    document.addEventListener('keydown', (e) => {
        if ((e.key === 'Enter' || e.key === ' ') && e.target.matches && e.target.matches('[data-option-pick]')) {
            e.preventDefault();
            e.target.click();
        }
    }, true);

    // ---------- Forms: order note + add to cart ----------
    document.addEventListener('submit', async (e) => {
        const noteForm = e.target.closest('form[data-cart-note]');
        if (noteForm) {
            e.preventDefault();
            try {
                await send(noteForm.action, { note: noteForm.elements.note.value });
                noteForm.querySelector('.tf-mini-cart-tool-close')?.click();
            } catch (err) {
                alert('Sorry, the note could not be saved.');
            }
            return;
        }

        const form = e.target.closest('form[data-ajax-cart]');
        if (!form) return;

        const missing = missingOption(form);
        if (missing) {
            e.preventDefault();
            showFormError(form, missing);
            return;
        }

        if (e.submitter && e.submitter.name === 'buy_now') return;

        e.preventDefault();
        const btn = e.submitter;
        if (btn) btn.disabled = true;

        try {
            const data = await send(form.action, Object.fromEntries(new FormData(form)));
            render(data);
            openDrawer();
        } catch (err) {
            if (err.status === 422) {
                showFormError(form, err.data?.errors?.options?.[0] || err.data?.message || 'Please check your selection.');
            } else {
                form.submit();
            }
        } finally {
            if (btn) btn.disabled = false;
        }
    });

    // ---------- Clicks ----------
    document.addEventListener('click', async (e) => {
        // Any cart link outside the drawer opens the drawer
        const cartLink = e.target.closest('a[href$="/cart"], a[data-open-cart]');
        if (cartLink && !cartLink.closest('#shoppingCart')) {
            if (drawerEl && window.bootstrap) {
                e.preventDefault();
                openDrawer();
            }
            return;
        }

        // Quick view: open and load
        const quick = e.target.closest('[data-quick-view]');
        if (quick) {
            e.preventDefault();
            const modalEl = document.getElementById('quickView');
            const body = document.getElementById('quickViewBody');
            if (!modalEl || !body || !window.bootstrap) return;

            if (modalEl.parentElement !== document.body) document.body.appendChild(modalEl);

            body.innerHTML = '<div class="p-5 text-center w-100">Loading…</div>';
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
            try {
                const data = await getJson(quick.dataset.quickView);
                body.innerHTML = data.html;
                initQuickViewSlider();
            } catch (err) {
                body.innerHTML = '<div class="p-5 text-center w-100">Sorry, this product could not be loaded.</div>';
            }
            return;
        }

        // Quick view: quantity stepper
        const step = e.target.closest('[data-qv-step]');
        if (step) {
            const input = step.closest('.wg-quantity')?.querySelector('input');
            if (!input) return;
            const max = parseInt(input.max, 10) || 1;
            const next = (parseInt(input.value, 10) || 1) + parseInt(step.dataset.qvStep, 10);
            input.value = Math.min(Math.max(next, 1), max);
            return;
        }

        // Cart drawer: quantity, remove, empty cart
        const qty = e.target.closest('[data-cart-qty]');
        const rm = e.target.closest('[data-cart-remove]');
        const clear = e.target.closest('[data-cart-clear]');
        if (!qty && !rm && !clear) return;

        e.preventDefault();
        try {
            let data;
            if (qty) data = await send(qty.dataset.url, { qty: qty.dataset.qty }, 'PATCH');
            else if (rm) data = await send(rm.dataset.url, {}, 'DELETE');
            else data = await send(clear.dataset.url, {}, 'DELETE');
            render(data);
        } catch (err) {
            alert('Sorry, something went wrong. Please try again.');
        }
    });

    // ---------- Search: live suggestions in the theme's offcanvas ----------
    const searchEl = document.getElementById('search');
    const searchInput = searchEl?.querySelector('[data-search-input]');
    const searchList = searchEl?.querySelector('[data-search-list]');
    const searchTitle = searchEl?.querySelector('[data-search-title]');

    if (searchEl && searchInput && searchList) {
        const defaultHtml = searchList.innerHTML;
        const defaultTitle = searchTitle ? searchTitle.textContent : '';
        const placeholder = searchInput.dataset.placeholder;
        let timer;

        searchEl.addEventListener('shown.bs.offcanvas', () => searchInput.focus());

        searchInput.addEventListener('input', () => {
            clearTimeout(timer);
            const q = searchInput.value.trim();

            if (q.length < 2) {
                searchList.innerHTML = defaultHtml;
                if (searchTitle) searchTitle.textContent = defaultTitle;
                return;
            }

            timer = setTimeout(async () => {
                try {
                    const items = (await getJson(searchInput.dataset.suggestUrl + '?q=' + encodeURIComponent(q))).slice(0, 4);
                    if (searchInput.value.trim() !== q) return;

                    if (searchTitle) searchTitle.textContent = 'RESULTS';
                    searchList.innerHTML = items.length
                        ? items.map((p) => `
                            <li>
                                <div class="tf-product-mini-view">
                                    <a href="${esc(p.url)}" class="prd-image"><img src="${esc(p.image || placeholder)}" alt=""></a>
                                    <div class="prd-content">
                                        <a href="${esc(p.url)}" class="prd-name link text-uppercase">${esc(p.name)}</a>
                                        <div class="price-wrap">
                                            ${p.sold_out ? '<span class="text-caption">Sold out</span>' : '<span class="price-new">' + esc(p.price) + '</span>'}
                                        </div>
                                    </div>
                                </div>
                            </li>`).join('')
                        : '<li class="text-main-4">No matches yet. Press Enter to search everything.</li>';
                } catch (err) {
                    /* keep whatever is showing */
                }
            }, 250);
        });
    }
        // ---------- Header search box: dropdown with suggestions ----------
    const hs = document.querySelector('[data-header-search]');

    if (hs) {
        const input = hs.querySelector('[data-hs-input]');
        const panel = hs.querySelector('.hs-panel');
        const list = hs.querySelector('[data-hs-list]');
        const title = hs.querySelector('[data-hs-title]');
        const links = hs.querySelector('[data-hs-links]');
        const all = hs.querySelector('[data-hs-all]');
        const defaultHtml = list.innerHTML;
        const defaultTitle = title.textContent;
        const placeholder = input.dataset.placeholder;
        const resultsUrl = hs.querySelector('form').action;
        let timer;
        let active = -1;

        const items = () => Array.from(panel.querySelectorAll('.hs-item'));
        const highlight = (i) => {
            items().forEach((el, n) => el.classList.toggle('is-active', n === i));
            active = i;
        };
        const open = () => { panel.hidden = false; input.setAttribute('aria-expanded', 'true'); };
        const close = () => { panel.hidden = true; input.setAttribute('aria-expanded', 'false'); active = -1; };
        const showDefault = () => {
            list.innerHTML = defaultHtml;
            title.textContent = defaultTitle;
            if (links) links.hidden = false;
            all.hidden = true;
        };

        input.addEventListener('focus', () => {
            if (input.value.trim().length < 2) showDefault();
            open();
        });

        input.addEventListener('input', () => {
            clearTimeout(timer);
            active = -1;
            const q = input.value.trim();

            if (q.length < 2) {
                showDefault();
                open();
                return;
            }

            timer = setTimeout(async () => {
                try {
                    const found = (await getJson(input.dataset.suggestUrl + '?q=' + encodeURIComponent(q))).slice(0, 5);
                    if (input.value.trim() !== q) return; // a newer search is already running

                    title.textContent = found.length ? 'Results' : 'No matches';
                    list.innerHTML = found.length
                        ? found.map((p) => `
                            <li>
                                <a href="${esc(p.url)}" class="hs-item">
                                    <img src="${esc(p.image || placeholder)}" alt="">
                                    <span class="hs-name">${esc(p.name)}</span>
                                    <span class="hs-price">${p.sold_out ? 'Sold out' : esc(p.price)}</span>
                                </a>
                            </li>`).join('')
                        : '<li class="hs-empty">Nothing found yet. Try another word.</li>';

                    if (links) links.hidden = true;
                    all.href = resultsUrl + '?q=' + encodeURIComponent(q);
                    all.hidden = !found.length;
                    open();
                } catch (err) {
                    /* keep whatever is showing */
                }
            }, 200);
        });

        input.addEventListener('keydown', (e) => {
            const els = items();

            if (e.key === 'ArrowDown' && els.length) {
                e.preventDefault();
                highlight((active + 1) % els.length);
            } else if (e.key === 'ArrowUp' && els.length) {
                e.preventDefault();
                highlight((active - 1 + els.length) % els.length);
            } else if (e.key === 'Enter' && active >= 0 && els[active]) {
                e.preventDefault();
                window.location.href = els[active].href;
            } else if (e.key === 'Escape') {
                close();
                input.blur();
            }
        });

        document.addEventListener('click', (e) => {
            if (!hs.contains(e.target)) close();
        });
    }

    // ---------- Mobile menu search box: tapping it opens the full search panel ----------
    const menuSearch = document.querySelector('#mobileMenu .form-search input[name="q"]');

    if (menuSearch) {
        menuSearch.addEventListener('focus', () => {
            const menu = document.getElementById('mobileMenu');
            const panel = document.getElementById('search');
            if (!menu || !panel || !window.bootstrap) return;

            menu.addEventListener('hidden.bs.offcanvas', () => bootstrap.Offcanvas.getOrCreateInstance(panel).show(), { once: true });
            bootstrap.Offcanvas.getOrCreateInstance(menu).hide();
        });
    }
})();