<?php include 'header.php';
include_once('Ui-All-Function.php');
?>
<style>
    /* ==========================================
       1. CORE VARIABLES (Cafe Theme) & TYPOGRAPHY
    ========================================== */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap');

    :root {
        --cafe-dark: #8b3804;
        /* Deep Espresso Brown */
        --cafe-primary: #A67B5B;
        /* Warm Caramel / Coffee */
        --cafe-primary-hover: #8B5A2B;
        --cafe-bg: #faf7f2;
        /* Warm Creamy Off-White */
        --card-bg: #FFFFFF;
        --text-dark: #3E2723;
        --text-muted: #6c3603;
        --nav-height: 75px;

        /* Enhanced Shadow Effects for Cards */
        --card-shadow: 0 8px 25px rgba(44, 30, 22, 0.06);
        --card-shadow-hover: 0 15px 35px rgba(44, 30, 22, 0.12);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background-color: var(--cafe-bg);
        font-family: 'Poppins', sans-serif;
        color: var(--text-dark);
        padding-top: var(--nav-height);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
    }

    .font-serif {
        font-family: 'Playfair Display', serif;
    }

    .font-sans {
        font-family: 'Poppins', sans-serif;
    }

    main {
        flex-grow: 1;
        padding-bottom: 2rem;
    }

    /* ==========================================
       2. SLEEK & SHORT HERO BANNER
    ========================================== */
    .menu-hero {
        background: url("https://images.unsplash.com/photo-1497935586351-b67a49e012bf?q=80&w=2000&auto=format&fit=crop") center/cover no-repeat;
        position: relative;
        padding: 4.5rem 2rem;
        display: flex;
        align-items: center;
    }

    /* Warm dark gradient overlay */
    .menu-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(44, 30, 22, 0.95) 0%, rgba(44, 30, 22, 0.7) 50%, rgba(44, 30, 22, 0.2) 100%);
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 1200px;
        margin: 0 auto;
        width: 100%;
        color: #fff;
    }

    .hero-content h1 {
        font-size: 3.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        letter-spacing: 1px;
        color: #FAF8F5;
    }

    .hero-content p {
        font-size: 1.1rem;
        color: rgba(250, 248, 245, 0.85);
        font-weight: 300;
    }

    /* ==========================================
       3. STYLISH CATEGORY FILTER (UPDATED)
    ========================================== */
    .filter-section {
        padding: 3rem 0;
        text-align: center;
    }

    .filter-container {
        display: inline-flex;
        background: #FFFFFF;
        padding: 10px;
        border-radius: 50px;
        box-shadow: 0 10px 30px rgba(44, 30, 22, 0.08);
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
        position: relative;
        border: 1px solid rgba(166, 123, 91, 0.15);
    }

    .filter-btn {
        background: transparent;
        border: none;
        border-radius: 40px;
        color: var(--text-muted);
        padding: 12px 28px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        position: relative;
        z-index: 1;
        transition: color 0.4s ease;
    }

    /* Spring Bubble Background Effect */
    .filter-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: var(--cafe-dark);
        border-radius: 40px;
        z-index: -1;
        transform: scale(0.5);
        opacity: 0;
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        /* Smooth spring/bounce */
    }

    .filter-btn:hover {
        color: var(--cafe-primary);
    }

    .filter-btn.active {
        color: #ffffff;
    }

    .filter-btn.active::before {
        transform: scale(1);
        opacity: 1;
        background: linear-gradient(135deg, #6d3403 0%, #5a2a02 100%);
        box-shadow: 0 6px 15px rgba(44, 30, 22, 0.3);
    }

    /* ==========================================
       NEW PREMIUM ANIMATIONS
    ========================================== */
    .fade-in {
        opacity: 0;
        animation: smoothReveal 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes smoothReveal {
        0% {
            opacity: 0;
            transform: translateY(40px) scale(0.95);
            filter: blur(10px);
        }

        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }
    }

    /* ==========================================
       4. PRODUCT CARDS (Cafe Style)
    ========================================== */
    .menu-item {
        transition: all 0.5s ease;
    }

    .product-card {
        background: var(--card-bg);
        border-radius: 20px;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.09);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid rgba(166, 123, 91, 0.1);
        /* Subtle coffee border */
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--card-shadow-hover);
    }

    .img-box {
        position: relative;
        padding-top: 75%;
        overflow: hidden;
        background: #F3EFE9;
    }

    .img-box img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 1s ease;
    }

    .product-card:hover .img-box img {
        transform: scale(1.08);
    }

    /* Badges & Icons */
    .badge-available {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(255, 255, 255, 0.95);
        color: var(--cafe-dark);
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        backdrop-filter: blur(4px);
    }

    .badge-available .dot {
        width: 7px;
        height: 7px;
        background-color: #28a745;
        border-radius: 50%;
        display: inline-block;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
        }

        70% {
            transform: scale(1);
            box-shadow: 0 0 0 6px rgba(40, 167, 69, 0);
        }

        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
        }
    }

    .btn-favorite {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.95);
        border: none;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        color: #9e9e9e; /* Neutral gray — red is ONLY set by .is-favorited class via JS */
        font-size: 1.1rem;
        z-index: 2;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }

    .btn-favorite:hover {
        transform: scale(1.1);
        color: #dc3545;
    }

    /* Red state: ONLY applied when JS injects this class after auth check */
    .btn-favorite.is-favorited {
        color: #dc3545;
    }

    /* Legacy alias — keep for backward compat but .is-favorited is canonical */
    .btn-favorite.liked {
        color: #dc3545;
        /* Red Heart */
    }

    /* Content Area */
    .info-box {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .info-box h3 {
        font-size: 1.35rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.4rem;
    }

    .info-box p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-bottom: 1.5rem;
        line-height: 1.5;
    }

    .card-bottom {
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .price {
        font-size: 1.4rem;
        font-weight: 600;
        color: var(--cafe-dark);
    }

    .price::before {
        content: '₹ ';
        font-size: 1rem;
        color: var(--cafe-primary);
    }


    /* Stylish Order Button (Premium Vibe) */

    .order-btn {
        background: linear-gradient(135deg, #a95103 0%, #5a2a02 100%);
        /* Rich coffee gradient */
        color: #ffffff;
        border: none;
        padding: 9px 24px;
        border-radius: 30px;
        font-size: 0.95rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        position: relative;
        overflow: hidden;
        /* For the shine effect */
        box-shadow: 0 4px 15px rgba(121, 59, 4, 0.2);
        /* Soft initial shadow */
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Moving Shine Effect Setup */
    .order-btn::after {
        content: '';
        position: absolute;
        top: 0;
        left: -150%;
        width: 50%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
        transform: skewX(-25deg);
        transition: all 0.6s ease;
    }

    /* Hover State */
    .order-btn:hover {
        background: linear-gradient(135deg, #e67e22 0%, #cc6607 100%);
        /* Vibrant warm orange */
        transform: translateY(-3px);
        /* Lifts the button slightly */
        box-shadow: 0 8px 20px rgba(204, 102, 7, 0.35);
        /* Stronger, glowing shadow */
        color: #ffffff;
    }

    /* Trigger Shine on Hover */
    .order-btn:hover::after {
        left: 150%;
        /* Moves the shine effect across the button */
    }

    /* Active/Click State for Tactile Feel */
    .order-btn:active {
        transform: translateY(1px) scale(0.96);
        /* Button presses down */
        box-shadow: 0 2px 10px rgba(121, 59, 4, 0.2);
    }



    .no-items-message {
        text-align: center;
        padding: 4rem 2rem;
    }

    .no-items-message h4 {
        font-size: 2rem;
        color: var(--cafe-dark);
        margin-bottom: 0.5rem;
    }

    /* ==========================================
       5. RESPONSIVE DESIGN
    ========================================== */
    @media (max-width: 768px) {
        .menu-hero {
            padding: 3rem 1rem;
            text-align: center;
        }

        .menu-hero::before {
            background: rgba(44, 30, 22, 0.8);
        }

        .hero-content h1 {
            font-size: 2.5rem;
        }

        .hero-content p {
            font-size: 0.95rem;
        }

        .filter-container {
            border-radius: 15px;
            padding: 10px;
        }

        .filter-btn {
            padding: 8px 16px;
            font-size: 0.85rem;
            border-radius: 8px;
        }

        .info-box {
            padding: 1.2rem;
        }

        .info-box h3 {
            font-size: 1.2rem;
        }

        .price {
            font-size: 1.2rem;
        }

        .order-btn {
            padding: 8px 18px;
            font-size: 0.85rem;
        }
    }


    .ord_btn {
        text-decoration: none;
    }

    /* =====================================================
       MOBILE CAROUSEL — reinforced here so Bootstrap col
       classes cannot win over the carousel flex layout.
       Matches the breakpoint in media.css exactly.
    ===================================================== */
    @media (max-width: 767px) {

        /* Carousel container */
        #menuGrid {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            overflow-y: visible !important;
            scroll-snap-type: x mandatory !important;
            -webkit-overflow-scrolling: touch !important;
            justify-content: flex-start !important;
            padding-bottom: 0.5rem !important;
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
        }

        #menuGrid::-webkit-scrollbar {
            display: none !important;
        }

        /* Every visible card: full-width flex item, snaps to center */
        #menuGrid > .menu-item {
            display: block !important;  /* override any Bootstrap col display */
            flex: 0 0 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            width: 100% !important;
            scroll-snap-align: center !important;
            scroll-snap-stop: always !important;
        }

        /* Hidden items must not consume flex space */
        #menuGrid > .menu-item[style*="display: none"],
        #menuGrid > .menu-item[style*="display:none"] {
            display: none !important;
            flex: none !important;
            min-width: 0 !important;
            max-width: 0 !important;
        }

    }

    /* =====================================================
       DESKTOP PAGINATION CONTROLS
       Shown only on desktop (> 992px). Hidden entirely on
       mobile and tablet via the default display: none rule.
    ===================================================== */

    /* Hidden by default on all breakpoints */
    .desktop-pagination {
        display: none;
    }

    /* Only render on desktop */
    @media (min-width: 993px) {

        .desktop-pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin: 32px 0 8px;
            flex-wrap: wrap;
        }

        /* Shared base for all pagination buttons */
        .desktop-pagination .pg-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 12px;
            border-radius: 10px;
            border: 1.5px solid #e0d5cc;
            background: #ffffff;
            color: #3e2723;
            font-family: 'Poppins', sans-serif;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.18s ease, color 0.18s ease,
                        border-color 0.18s ease, transform 0.15s ease,
                        box-shadow 0.18s ease;
            line-height: 1;
            user-select: none;
            -webkit-tap-highlight-color: transparent;
        }

        .desktop-pagination .pg-btn:hover:not(:disabled):not(.pg-ellipsis) {
            background: #f5ede4;
            border-color: #c98d4d;
            color: #5a2d03;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(201, 141, 77, 0.18);
        }

        .desktop-pagination .pg-btn:active:not(:disabled):not(.pg-ellipsis) {
            transform: translateY(0);
            box-shadow: none;
        }

        /* Active / current page */
        .desktop-pagination .pg-btn.pg-active {
            background: linear-gradient(135deg, #c98d4d 0%, #a06830 100%);
            border-color: #a06830;
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(160, 104, 48, 0.35);
            cursor: default;
        }

        /* Disabled prev/next at boundaries */
        .desktop-pagination .pg-btn:disabled,
        .desktop-pagination .pg-btn[disabled] {
            opacity: 0.35;
            cursor: default;
            pointer-events: none;
        }

        /* Ellipsis separator */
        .desktop-pagination .pg-ellipsis {
            border: none;
            background: transparent;
            cursor: default;
            color: #9e9e9e;
            letter-spacing: 1px;
            min-width: 28px;
            padding: 0 4px;
        }

        /* Prev / Next labels include chevron icons */
        .desktop-pagination .pg-prev,
        .desktop-pagination .pg-next {
            padding: 0 16px;
            gap: 6px;
            font-size: 0.82rem;
            letter-spacing: 0.3px;
        }

    }

</style>

<main>
    <section class="menu-hero">
        <div class="hero-content text-center">
            <h1 class="font-serif">Our Special Menu</h1>
            <p class="font-sans">Discover our signature blends and handcrafted beverages.</p>
        </div>
    </section>

    <div class="filter-section">
        <div class="container">
            <div class="filter-container font-sans">
                <button class="filter-btn active" data-filter="all">
                    All Items
                </button>

                <?php
                $allcategory = AllDetails('categories');
                foreach ($allcategory as $category) {
                ?>
                    <button
                        class="filter-btn"
                        data-filter="<?php echo strtolower(str_replace(' ', '-', $category['name'])); ?>">

                        <?php echo $category['name']; ?>

                    </button>

                <?php } ?>

            </div>
        </div>
    </div>

    <div class="container pb-3 position-relative">
        <div class="row g-4 justify-content-center" id="menuGrid">

            <?php
            // Build a lookup map: category numeric ID → sanitised CSS slug
            // This ensures .menu-item class matches the filter button data-filter value.
            $category_map = [];
            $allcats = AllDetails('categories');
            if ($allcats) {
                foreach ($allcats as $cat) {
                    $category_map[$cat['id']] = strtolower(str_replace(' ', '-', $cat['name']));
                }
            }

            if (isset($_SESSION['id'])) {

                $Allcafeitems = Allproducts('products');
                foreach ($Allcafeitems as $item) {
                    $cat_slug = $category_map[$item['category_id']] ?? 'uncategorised';
            ?>

                    <div class="col-xl-3 col-lg-4 col-md-6 menu-item <?php echo $cat_slug; ?>">
                        <div class="product-card">
                            <div class="img-box">
                                <div class="badge-available"><span class="dot"></span> Available</div>
                                <?php
                                $product_avl = accesss_favorite_item($item['id']);
                                if ($product_avl) {
                                ?>
                                    <button class="btn-favorite is-favorited"
                                        data-product-id="<?php echo $item['id']; ?>"
                                        data-action="remove"
                                        title="Remove from favorites"
                                        style="z-index:99;">
                                        <i class="fa-solid fa-heart"></i>
                                    </button>
                                <?php } else { ?>
                                    <button class="btn-favorite"
                                        data-product-id="<?php echo $item['id']; ?>"
                                        data-action="add"
                                        title="Add to favorites"
                                        style="z-index:99;">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                <?php } ?>
                                <img src="upload/<?php echo $item['image'] ?>" alt="Orange">
                            </div>
                            <div class="info-box">
                                <h3 class="font-sans"><?php echo  $item['name'] ?></h3>
                                <p class="font-sans"><?php echo  $item['description'] ?></p>
                                <div class="card-bottom">
                                    <span class="price font-sans">140</span>
                                    <a class="ord_btn" href="order_page.php?id=<?php echo $item['id'] ?>&btn=order"><button class="order-btn font-sans">Order Now</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {


                $Allcafeitems = Allproducts('products');
                foreach ($Allcafeitems as $item) {
                    $cat_slug = $category_map[$item['category_id']] ?? 'uncategorised';
                ?>

                    <div class="col-xl-3 col-lg-4 col-md-6 menu-item <?php echo $cat_slug; ?>">
                        <div class="product-card">
                            <div class="img-box">
                                <div class="badge-available"><span class="dot"></span> Available</div>
                                <button class="btn-favorite"
                                    data-action="guest"
                                    title="Add to favorites"
                                    style="z-index:99;">
                                    <i class="fa-regular fa-heart"></i>
                                </button>

                                <img src="upload/<?php echo $item['image'] ?>" alt="Orange">
                            </div>
                            <div class="info-box">
                                <h3 class="font-sans"><?php echo  $item['name'] ?></h3>
                                <p class="font-sans"><?php echo  $item['description'] ?></p>
                                <div class="card-bottom">
                                    <span class="price font-sans">140</span>
                                    <a class="ord_btn" href="javascript:void(0)" onclick="showGuestAlert('Order Now')"><button class="order-btn font-sans">Order Now</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>

        </div>

        <div id="noItemsMessage" class="no-items-message" style="display: none;">
            <i class="fa-solid fa-mug-hot" style="font-size: 3rem; color: var(--cafe-primary); margin-bottom: 15px; opacity: 0.5;"></i>
            <h4 class="font-serif">No Items Found</h4>
            <p class="font-sans text-muted">We are currently crafting new beverages for this category.</p>
        </div>

        <nav class="desktop-pagination" id="desktopPagination" aria-label="Product page navigation"></nav>

        <!-- Mobile Carousel Pagination — hidden on desktop via CSS -->
        <div class="carousel-pagination" id="menuCarouselPagination" aria-label="Product carousel navigation">
            <button class="carousel-arrow carousel-arrow--prev" id="menuCarouselPrev" aria-label="Previous product">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <div class="carousel-dots" id="menuCarouselDots" role="tablist"></div>
            <button class="carousel-arrow carousel-arrow--next" id="menuCarouselNext" aria-label="Next product">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>

    </div>
</main>


<script>
// ================================================================
// Menu Page — Unified Filter + Pagination Controller
//
// Responsibilities:
//   • Category filter (both mobile + desktop)
//   • Desktop pagination (>992px): 8 items / page, numbered buttons
//   • Mobile carousel re-init (≤767px): calls window.initCarouselPagination
//
// Architecture:
//   All three concerns share ONE matched-items array so there is
//   a single source of truth. Filter always resets pagination to page 1.
//   Mobile and desktop paths are mutually exclusive at runtime.
// ================================================================

(function () {

    // ── DOM refs ──────────────────────────────────────────────────
    const filterBtns    = document.querySelectorAll('.filter-btn');
    const allItems      = Array.from(document.querySelectorAll('.menu-item'));
    const noItemsMsg    = document.getElementById('noItemsMessage');
    const carousel      = document.getElementById('menuGrid');
    const pgContainer   = document.getElementById('desktopPagination');

    // ── Config ────────────────────────────────────────────────────
    const ITEMS_PER_PAGE    = 8;
    const DESKTOP_MIN_WIDTH = 993; // px — must match CSS @media min-width

    // ── State ─────────────────────────────────────────────────────
    let currentFilter  = 'all';
    let matchedItems   = [];   // items matching the active category
    let currentPage    = 1;
    let totalPages     = 1;

    // ─────────────────────────────────────────────────────────────
    // Utility: is the viewport in desktop range?
    // ─────────────────────────────────────────────────────────────
    function isDesktop() {
        return window.innerWidth >= DESKTOP_MIN_WIDTH;
    }

    // ─────────────────────────────────────────────────────────────
    // STEP 1 — Build the matched list for the active category.
    //          Sets every item's base visibility (no paging yet).
    // ─────────────────────────────────────────────────────────────
    function applyFilter(filter) {
        currentFilter = filter;
        matchedItems  = [];

        allItems.forEach(function (item) {
            item.classList.remove('fade-in');
            const matches = filter === 'all' || item.classList.contains(filter);
            if (matches) {
                matchedItems.push(item);
            } else {
                // Definitively hide non-matching items
                item.style.display = 'none';
            }
        });
    }

    // ─────────────────────────────────────────────────────────────
    // STEP 2a — DESKTOP: show only the items on the current page
    // ─────────────────────────────────────────────────────────────
    function applyDesktopPage(page) {
        currentPage = page;
        totalPages  = Math.max(1, Math.ceil(matchedItems.length / ITEMS_PER_PAGE));
        currentPage = Math.min(currentPage, totalPages);

        const start = (currentPage - 1) * ITEMS_PER_PAGE;
        const end   = start + ITEMS_PER_PAGE;

        matchedItems.forEach(function (item, index) {
            item.classList.remove('fade-in');
            if (index >= start && index < end) {
                item.style.display = '';
                void item.offsetWidth;
                item.classList.add('fade-in');
            } else {
                item.style.display = 'none';
            }
        });

        if (noItemsMsg) {
            noItemsMsg.style.display = matchedItems.length === 0 ? 'block' : 'none';
        }

        renderDesktopPagination();
    }

    // ─────────────────────────────────────────────────────────────
    // STEP 2b — MOBILE: show ALL matched items (carousel scrolls)
    // ─────────────────────────────────────────────────────────────
    function applyMobilePage() {
        matchedItems.forEach(function (item) {
            item.style.display = '';
            void item.offsetWidth;
            item.classList.add('fade-in');
        });

        if (noItemsMsg) {
            noItemsMsg.style.display = matchedItems.length === 0 ? 'block' : 'none';
        }

        if (carousel) carousel.scrollLeft = 0;

        // Rebuild carousel dots after next paint so widths are settled
        requestAnimationFrame(function () {
            if (typeof window.initCarouselPagination === 'function') {
                window.initCarouselPagination();
            }
        });
    }

    // ─────────────────────────────────────────────────────────────
    // STEP 3 — Render the desktop pagination button strip
    // ─────────────────────────────────────────────────────────────
    function renderDesktopPagination() {
        if (!pgContainer) return;
        pgContainer.innerHTML = '';

        // Don't render if only one page
        if (totalPages <= 1) return;

        // Helper: create a button
        function makeBtn(label, title, onClick, extraClass) {
            const btn = document.createElement('button');
            btn.className  = 'pg-btn' + (extraClass ? ' ' + extraClass : '');
            btn.innerHTML  = label;
            btn.title      = title || label;
            btn.setAttribute('aria-label', title || label);
            if (onClick) btn.addEventListener('click', onClick);
            return btn;
        }

        function makeEllipsis() {
            const e = document.createElement('span');
            e.className = 'pg-btn pg-ellipsis';
            e.textContent = '…';
            e.setAttribute('aria-hidden', 'true');
            return e;
        }

        // ── Prev button ──
        const prevBtn = makeBtn(
            '<i class="fa-solid fa-chevron-left" style="font-size:.75rem"></i>&nbsp;Prev',
            'Previous page',
            function () { goToPage(currentPage - 1); },
            'pg-prev'
        );
        if (currentPage <= 1) prevBtn.disabled = true;
        pgContainer.appendChild(prevBtn);

        // ── Page number buttons (with ellipsis for large ranges) ──
        // Always show: first, last, current, and ±1 around current.
        const pages = buildPageRange(currentPage, totalPages);
        pages.forEach(function (p) {
            if (p === '…') {
                pgContainer.appendChild(makeEllipsis());
            } else {
                const btn = makeBtn(
                    String(p),
                    'Go to page ' + p,
                    function () { goToPage(p); }
                );
                if (p === currentPage) {
                    btn.classList.add('pg-active');
                    btn.disabled = true;
                    btn.setAttribute('aria-current', 'page');
                }
                pgContainer.appendChild(btn);
            }
        });

        // ── Next button ──
        const nextBtn = makeBtn(
            'Next&nbsp;<i class="fa-solid fa-chevron-right" style="font-size:.75rem"></i>',
            'Next page',
            function () { goToPage(currentPage + 1); },
            'pg-next'
        );
        if (currentPage >= totalPages) nextBtn.disabled = true;
        pgContainer.appendChild(nextBtn);
    }

    // Build a smart page number array, e.g. [1,'…',4,5,6,'…',12]
    function buildPageRange(current, total) {
        if (total <= 7) {
            // Show all pages if 7 or fewer
            return Array.from({ length: total }, function (_, i) { return i + 1; });
        }
        var pages = [];
        pages.push(1);
        if (current > 3) pages.push('…');
        var start = Math.max(2, current - 1);
        var end   = Math.min(total - 1, current + 1);
        for (var p = start; p <= end; p++) pages.push(p);
        if (current < total - 2) pages.push('…');
        pages.push(total);
        return pages;
    }

    // ─────────────────────────────────────────────────────────────
    // Navigate to a page number (desktop only)
    // ─────────────────────────────────────────────────────────────
    function goToPage(page) {
        if (!isDesktop()) return;
        page = Math.max(1, Math.min(page, totalPages));
        applyDesktopPage(page);
        // Smooth-scroll to top of grid
        if (carousel) {
            carousel.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    // ─────────────────────────────────────────────────────────────
    // Master entry point — called by filter buttons and on load
    // ─────────────────────────────────────────────────────────────
    function triggerFilter(button) {
        // ── 1. Activate the clicked tab ──
        filterBtns.forEach(function (btn) { btn.classList.remove('active'); });
        button.classList.add('active');

        const filter = button.dataset.filter;

        // ── 2. Build the matched list for this category ──
        applyFilter(filter);

        // ── 3. Route to the correct layout mode ──
        if (isDesktop()) {
            // Desktop: paginated grid — always start at page 1 on filter change
            applyDesktopPage(1);
        } else {
            // Mobile: full carousel — show all matched items
            applyMobilePage();
        }
    }

    // ─────────────────────────────────────────────────────────────
    // Event listeners
    // ─────────────────────────────────────────────────────────────
    filterBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            triggerFilter(this);
        });
    });

    // Re-run when viewport crosses the desktop/mobile boundary
    var resizeDebounce;
    window.addEventListener('resize', function () {
        clearTimeout(resizeDebounce);
        resizeDebounce = setTimeout(function () {
            var activeBtn = document.querySelector('.filter-btn.active');
            if (activeBtn) triggerFilter(activeBtn);
        }, 220);
    });

    // ── Run on page load for the default active tab ──
    window.addEventListener('load', function () {
        var activeBtn = document.querySelector('.filter-btn.active');
        if (activeBtn) triggerFilter(activeBtn);
    });

})();
</script>


<footer>
    <?php include_once('footer.php') ?>
</footer>