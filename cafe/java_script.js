
    // ==========================================
    // 1. Favorite Button & Sidebar AJAX Logic
    // ==========================================
    
    // Helper: Construct HTML for a favorite card in the sidebar
    function createFavoriteCardHTML(product) {
        const id = product.id;
        const name = product.name || 'Item';
        const price = product.price || '';
        const image = product.image || 'default.jpg';

        return `
            <div class="card cafe-fav-card mb-3 shadow-sm" data-product-id="${id}">
                <div class="row g-0 align-items-center h-100 w-75">
                    <div class="col-4 h-100">
                        <img src="upload/${image}" style="height: 15vh; width:100%;" alt="${name}">
                    </div>
                    <div class="col-8">
                        <div class="card-body py-2 px-3">
                            <h6 class="card-title fw-bold mb-1 text-dark">Item : ${name}</h6>
                            <p class="card-text fw-bold text-cafe-price mb-2">Rs : ${price}</p>
                            <div class="d-flex gap-2 align-items-center">
                                <!-- Order Button -->
                                <a href="order_page.php?id=${id}&btn=order" class="fm-action-btn fm-order-btn font-sans">
                                    <i class="fa-solid fa-cart-shopping"></i> Order
                                </a>

                                <!-- Remove Button -->
                                <a href="Ui-All-Function.php?pid=${id}&btn=remove" class="fm-action-btn fm-remove-btn fav-remove-btn font-sans" data-product-id="${id}" title="Remove from Favorites">
                                    <i class="fa-solid fa-trash-can"></i> Remove
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
    }

    // Helper: Dynamically append/prepend newly favorited item to sidebar
    function addFavoriteToSidebar(product) {
        const container = document.getElementById('favoriteItemsContainer');
        if (!container || !product || !product.id) return;

        // Remove empty state placeholder if present
        const emptyMsg = container.querySelector('.empty-fav-msg') || 
            Array.from(container.querySelectorAll('.card')).find(c => c.textContent.includes('No items Added'));
        if (emptyMsg) {
            emptyMsg.remove();
        }

        // Avoid duplicate card in sidebar DOM
        const existingCard = container.querySelector(`.cafe-fav-card[data-product-id="${product.id}"]`);
        if (!existingCard) {
            const cardHtml = createFavoriteCardHTML(product);
            container.insertAdjacentHTML('afterbegin', cardHtml);
        }
    }

    // Helper: Dynamically remove favorited item from sidebar
    function removeFavoriteFromSidebar(productId) {
        const container = document.getElementById('favoriteItemsContainer');
        if (!container) return;

        const existingCard = container.querySelector(`.cafe-fav-card[data-product-id="${productId}"]`);
        if (existingCard) {
            existingCard.remove();
        }

        // If no more items remain, show empty state placeholder
        const remaining = container.querySelectorAll('.cafe-fav-card:not(.empty-fav-msg)');
        if (remaining.length === 0) {
            container.innerHTML = `
                <div class="card cafe-fav-card mb-3 shadow-sm empty-fav-msg">
                    <div class="row g-0 align-items-center h-100">
                        <h3 class="text-center p-2">No items Added</h3>
                    </div>
                </div>`;
        }
    }

    // Helper: Sync heart icon UI across product cards
    function syncProductHeartButtons(productId, isFavorited) {
        document.querySelectorAll(`.btn-favorite[data-product-id="${productId}"]`).forEach(b => {
            const ic = b.querySelector('i');
            if (isFavorited) {
                b.classList.add('is-favorited');
                b.dataset.action = 'remove';
                b.title = 'Remove from favorites';
                if (ic) {
                    ic.classList.remove('fa-regular');
                    ic.classList.add('fa-solid');
                }
            } else {
                b.classList.remove('is-favorited', 'liked', 'active');
                b.dataset.action = 'add';
                b.title = 'Add to favorites';
                if (ic) {
                    ic.classList.remove('fa-solid');
                    ic.classList.add('fa-regular');
                }
            }
        });
    }

    // Helper: Update navbar favorites badge count
    function updateFavoriteBadge(count) {
        const favCount = document.getElementById('favCount');
        if (favCount && typeof count !== 'undefined') {
            favCount.textContent = count;
        }
    }

    // 1A. Product Card Heart Icon Click (Toggle Add/Remove)
    const favoriteBtns = document.querySelectorAll('.btn-favorite');

    favoriteBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // Prevent rapid double clicking while processing
            if (this.dataset.busy === '1') {
                return;
            }

            const action = this.dataset.action; // 'guest' | 'add' | 'remove'
            const icon = this.querySelector('i');
            const productId = this.dataset.productId;

            if (action === 'guest' || !productId) {
                this.classList.remove('is-favorited', 'liked', 'active');
                if (icon) {
                    icon.classList.remove('fa-solid');
                    icon.classList.add('fa-regular');
                }
                if (typeof showGuestAlert === 'function') {
                    showGuestAlert('Add to Favorite');
                } else if (typeof cafeAlert === 'function') {
                    cafeAlert('Sign In Required', 'Please sign in to add items to your favorites!', 'warning', 'Login_form.php');
                } else {
                    window.location.href = 'Login_form.php';
                }
                return;
            }

            // User IS logged in: Toggle via AJAX
            const self = this;
            self.dataset.busy = '1';
            self.style.pointerEvents = 'none';

            fetch('Ui-All-Function.php?btn=favorite_btn&pid=' + encodeURIComponent(productId) + '&ajax=1', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                self.dataset.busy = '0';
                self.style.pointerEvents = 'auto';

                if (data.status === 'added') {
                    // Update heart icons on the page
                    syncProductHeartButtons(productId, true);
                    // Update navbar badge count
                    updateFavoriteBadge(data.total_count);

                    // Dynamically construct and append item into favorites sidebar
                    let prodData = data.product;
                    if (!prodData) {
                        const card = self.closest('.product-card');
                        prodData = {
                            id: productId,
                            name: card ? (card.querySelector('.info-box h3')?.textContent.trim() || 'Item') : 'Item',
                            price: card ? (card.querySelector('.price')?.textContent.trim() || '') : '',
                            image: card ? (card.querySelector('.img-box img')?.getAttribute('src')?.replace(/^upload\//, '') || 'default.jpg') : 'default.jpg'
                        };
                    }
                    addFavoriteToSidebar(prodData);

                } else if (data.status === 'removed') {
                    // Update heart icons on the page
                    syncProductHeartButtons(productId, false);
                    // Update navbar badge count
                    updateFavoriteBadge(data.total_count);
                    // Dynamically remove item from favorites sidebar
                    removeFavoriteFromSidebar(productId);

                } else if (data.status === 'login_required') {
                    self.classList.remove('is-favorited', 'liked', 'active');
                    self.dataset.action = 'guest';
                    if (icon) {
                        icon.classList.remove('fa-solid');
                        icon.classList.add('fa-regular');
                    }
                    if (typeof showGuestAlert === 'function') {
                        showGuestAlert('Add to Favorite');
                    } else {
                        window.location.href = 'Login_form.php';
                    }
                } else {
                    console.error('Wishlist error:', data.message || data);
                }
            })
            .catch(err => {
                self.dataset.busy = '0';
                self.style.pointerEvents = 'auto';
                console.error('Error toggling favorite:', err);
            });
        });
    });

    // 1B. Favorites Sidebar 'Remove' Button Click (Prevent Reload & Dynamic DOM Removal)
    document.addEventListener('click', function(e) {
        const removeBtn = e.target.closest('.fm-remove-btn, .fav-remove-btn');
        if (removeBtn && removeBtn.closest('#favoriteOffcanvas, #favoriteItemsContainer')) {
            e.preventDefault();
            e.stopPropagation();

            const card = removeBtn.closest('.cafe-fav-card, .card');
            const productId = removeBtn.dataset.productId || 
                (new URLSearchParams(removeBtn.getAttribute('href') ? removeBtn.getAttribute('href').split('?')[1] : '')).get('pid');

            if (!productId) return;
            if (removeBtn.dataset.busy === '1') return;

            removeBtn.dataset.busy = '1';
            removeBtn.style.pointerEvents = 'none';

            fetch('Ui-All-Function.php?btn=remove&pid=' + encodeURIComponent(productId) + '&ajax=1', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                removeBtn.dataset.busy = '0';
                removeBtn.style.pointerEvents = 'auto';

                if (data.status === 'removed') {
                    // Instantly remove specific product's HTML node from DOM
                    if (card) {
                        card.remove();
                    }

                    // Decrement or sync badge counter
                    if (typeof data.total_count !== 'undefined') {
                        updateFavoriteBadge(data.total_count);
                    } else {
                        const favCount = document.getElementById('favCount');
                        if (favCount) {
                            const current = parseInt(favCount.textContent, 10) || 1;
                            updateFavoriteBadge(Math.max(0, current - 1));
                        }
                    }

                    // Check if container is now empty
                    const container = document.getElementById('favoriteItemsContainer');
                    if (container) {
                        const remaining = container.querySelectorAll('.cafe-fav-card:not(.empty-fav-msg)');
                        if (remaining.length === 0) {
                            container.innerHTML = `
                                <div class="card cafe-fav-card mb-3 shadow-sm empty-fav-msg">
                                    <div class="row g-0 align-items-center h-100">
                                        <h3 class="text-center p-2">No items Added</h3>
                                    </div>
                                </div>`;
                        }
                    }

                    // Sync product card heart icons on main page
                    syncProductHeartButtons(productId, false);
                }
            })
            .catch(err => {
                removeBtn.dataset.busy = '0';
                removeBtn.style.pointerEvents = 'auto';
                console.error('Error removing favorite:', err);
            });
        }
    });

    // ==========================================
    // 2. Mobile Product Carousel Pagination
    // ==========================================
    // Only active on mobile (≤767px) — mirrors the CSS breakpoint.
    // Dynamically builds dots from visible card count, wires arrow
    // buttons, and syncs the active dot to the carousel scroll position.
    //
    // IMPORTANT: Filter logic is intentionally NOT here. Each page
    // (index.php, menu.php) owns its own filter script so there is
    // exactly ONE set of filter listeners per page. This function is
    // exposed on window so page-level filter scripts can call it after
    // a category change to rebuild the dots.
    // ==========================================

    (function () {

        const carousel   = document.getElementById('menuGrid');
        const dotsWrap   = document.getElementById('menuCarouselDots');
        const prevBtn    = document.getElementById('menuCarouselPrev');
        const nextBtn    = document.getElementById('menuCarouselNext');

        // Bail out if any required element is missing (page has no carousel)
        if (!carousel || !dotsWrap || !prevBtn || !nextBtn) return;

        let dots         = [];
        let rafId        = null;   // rAF handle for scroll-handler debounce
        let activeIndex  = 0;

        /** Returns visible (non-hidden) .menu-item elements as an array */
        function getVisibleCards() {
            return Array.from(carousel.querySelectorAll('.menu-item')).filter(
                el => el.style.display !== 'none'
            );
        }

        /** Build (or rebuild) the dot indicators to match visible card count */
        function buildDots(count) {
            dotsWrap.innerHTML = '';
            dots = [];

            for (let i = 0; i < count; i++) {
                const dot = document.createElement('span');
                dot.className    = 'carousel-dot' + (i === 0 ? ' is-active' : '');
                dot.setAttribute('role', 'tab');
                dot.setAttribute('aria-label', 'Go to product ' + (i + 1));
                dot.dataset.index = i;

                dot.addEventListener('click', function () {
                    scrollToCard(parseInt(this.dataset.index, 10));
                });

                dotsWrap.appendChild(dot);
                dots.push(dot);
            }
        }

        /** Smooth-scroll the carousel to a card by index */
        function scrollToCard(index) {
            const cards = getVisibleCards();
            if (!cards[index]) return;
            const cardWidth = cards[index].offsetWidth;
            carousel.scrollTo({ left: cardWidth * index, behavior: 'smooth' });
        }

        /** Mark the dot at `index` as active, deactivate all others */
        function setActiveDot(index) {
            if (index === activeIndex && dots[index] && dots[index].classList.contains('is-active')) return;
            activeIndex = index;
            dots.forEach((dot, i) => {
                dot.classList.toggle('is-active', i === index);
                dot.setAttribute('aria-selected', i === index ? 'true' : 'false');
            });
        }

        /** Toggle disabled state on the arrow buttons */
        function updateArrows(index, total) {
            prevBtn.disabled = index <= 0;
            nextBtn.disabled = index >= total - 1;
        }

        /** Read scroll position and sync the active dot */
        function syncDotsToScroll() {
            const cards = getVisibleCards();
            if (!cards.length) return;
            const cardWidth  = cards[0].offsetWidth;
            const index      = Math.min(
                Math.round(carousel.scrollLeft / cardWidth),
                cards.length - 1
            );
            setActiveDot(index);
            updateArrows(index, cards.length);
        }

        /** rAF-debounced scroll handler */
        function onScroll() {
            if (rafId) cancelAnimationFrame(rafId);
            rafId = requestAnimationFrame(syncDotsToScroll);
        }

        /**
         * Full (re-)initialisation.
         * Called once on page load, and again by page-level filter scripts
         * whenever the visible card set changes.
         */
        function initCarouselPagination() {
            const isMobile = window.innerWidth <= 767;
            const cards    = getVisibleCards();
            const count    = cards.length;

            if (!isMobile || count === 0) {
                dotsWrap.innerHTML = '';
                dots = [];
                return;
            }

            buildDots(count);
            carousel.scrollLeft = 0;
            setActiveDot(0);
            updateArrows(0, count);
        }

        // ---- Arrow click handlers ----
        prevBtn.addEventListener('click', function () {
            const cards = getVisibleCards();
            if (!cards.length) return;
            const cardWidth = cards[0].offsetWidth;
            const newIndex  = Math.max(0, Math.round(carousel.scrollLeft / cardWidth) - 1);
            scrollToCard(newIndex);
        });

        nextBtn.addEventListener('click', function () {
            const cards = getVisibleCards();
            if (!cards.length) return;
            const cardWidth = cards[0].offsetWidth;
            const total     = cards.length;
            const newIndex  = Math.min(total - 1, Math.round(carousel.scrollLeft / cardWidth) + 1);
            scrollToCard(newIndex);
        });

        // ---- Passive scroll listener ----
        carousel.addEventListener('scroll', onScroll, { passive: true });

        // ---- Rebuild on viewport resize / orientation change ----
        let resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(initCarouselPagination, 200);
        });

        // ---- Expose globally for page-level filter scripts ----
        window.initCarouselPagination = initCarouselPagination;

        // ---- First run (after layout is settled) ----
        if (document.readyState === 'complete') {
            initCarouselPagination();
        } else {
            window.addEventListener('load', initCarouselPagination);
        }

    })();
