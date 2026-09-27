<?php include 'header.php'; ?>

<style>
    :root {
        --cafe-dark: #231812;
        --cafe-brown: #3E2723;
        --cafe-gold: #D4AF37;
        --cafe-bg: #F9F6F0;
        --cafe-text: #5c534c;
    }

    body {
        background-color: var(--cafe-bg);
        font-family: 'Lato', sans-serif;
        color: var(--cafe-text);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    main {
        background-color: var(--cafe-bg);
    }

    h1,
    h2,
    h3,
    .cafe-serif {
        font-family: 'Playfair Display', serif;
        color: var(--cafe-dark);
    }

    /* --- HERO BANNER --- */
    .faq-hero {
        background: linear-gradient(rgba(35, 24, 18, .8), rgba(35, 24, 18, .7)), url("asset/image/faq-banner.webp");
        background-size: cover;
        background-position: center;
        padding: 7rem 0 6rem;
        text-align: center;
        color: white;
        border-bottom: 5px solid var(--cafe-gold);
    }

    .faq-hero h1 {
        color: white;
        font-size: 3.8rem;
        text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
        margin-bottom: 1rem;
    }

    .faq-hero p {
        color: #eaddcf;
        font-size: 1.2rem;
        font-weight: 300;
        letter-spacing: 1px;
    }

    /* --- TABLE WRAPPER --- */
    .cafe-table-wrapper {
        background: white;
        margin: -4rem auto 3rem;
        padding: 2.5rem;
        border-radius: 16px;
        position: relative;
        z-index: 10;
        box-shadow: 0 10px 30px rgba(35, 24, 18, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .cafe-table-wrapper:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(35, 24, 18, 0.12);
    }

    .table td,
    .table th {
        padding: 0.5rem 0.5rem;
        vertical-align: middle;
        color: var(--cafe-text);
    }

    .table thead th {
        border-bottom: 2px solid var(--cafe-gold);
        color: var(--cafe-dark);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 1px;
    }

    /* --- SEARCH BAR --- */
    .faq-search-box {
        position: relative;
        max-width: 600px;
        margin: 0 auto 3rem;
    }

    .faq-search-box i {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--cafe-gold);
        font-size: 1.2rem;
    }

    .faq-search-input {
        width: 100%;
        padding: 1rem 1rem 1rem 3.5rem;
        border-radius: 50px;
        border: 2px solid #eaddcf;
        font-size: 1.1rem;
        color: var(--cafe-dark);
        background: white;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.02);
    }

    .faq-search-input:focus {
        outline: none;
        border-color: var(--cafe-gold);
        box-shadow: 0 5px 20px rgba(212, 175, 55, 0.15);
    }

    /* --- ACCORDION UI --- */
    .accordion-item {
        border: none;
        margin-bottom: 1.2rem;
        overflow: hidden;
        border-radius: 12px !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .accordion-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(35, 24, 18, 0.08);
    }

    .accordion-button {
        padding: 1.5rem 1.8rem;
        font-size: 1.2rem;
        font-family: 'Playfair Display', serif;
        background: white;
        color: var(--cafe-dark);
        box-shadow: none;
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        text-align: left;
        border: none;
        cursor: pointer;
    }

    .accordion-button:hover {
        background: #fdfbf7;
    }

    .accordion-button:focus {
        box-shadow: none;
    }

    .accordion-button:not(.collapsed) {
        background: var(--cafe-dark) !important;
        color: var(--cafe-gold) !important;
    }

    .accordion-button::after {
        filter: grayscale(100%);
    }

    .accordion-button:not(.collapsed)::after {
        filter: brightness(0) saturate(100%) invert(80%) sepia(21%) saturate(738%) hue-rotate(345deg) brightness(92%) contrast(87%);
    }

    /* --- SMOOTH ACCORDION ANIMATION CLASSES --- */
    .accordion-content {
        display: grid;
        grid-template-rows: 0fr;
        transition: grid-template-rows 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
    }

    .accordion-content.show {
        grid-template-rows: 1fr;
    }

    .accordion-body-wrapper {
        overflow: hidden;
        /* Prevents text spill during the transition */
    }

    .accordion-body {
        padding: 0 1.8rem 1.5rem 1.8rem;
        /* Adjusted padding to look great with the animation */
        line-height: 1.8;
        font-size: 1.1rem;
        color: var(--cafe-text);
    }
</style>

<main>
    <!-- Hero Banner -->
    <section class="faq-hero">
        <div class="container">
            <h1>We're here to help</h1>
            <p>Everything you need to know about dining with us.</p>
        </div>
    </section>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <!-- Quick Reference Table -->
                <div class="cafe-table-wrapper">
                    <h3 class="h4 text-center mb-4 cafe-serif"><u>Hours of Operation</u></h3>
                    <div class="table-responsive">
                        <table class="table table-borderless text-center mb-0">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Open Hours</th>
                                    <th>Close Hours</th>
                                    <th>Open/Close</th>
                                </tr>
                            </thead>
                            <?php
                            function timetable(){
                            global $connect;
                            $sql = "SELECT * FROM cafe_timetable";
                            $run = mysqli_query($connect, $sql);
                            if (mysqli_num_rows($run)) {
                                return mysqli_fetch_all($run, MYSQLI_ASSOC);
                            } else {
                                return false;
                            }
                            }
                            ?>




                            <tbody>
                                <?php 
                                $timedetails=timetable();
                                foreach($timedetails as $time){ ?>
                                <tr>
                                    <td><strong><?php echo $time['day_name'];?></strong></td>
                                  <td><strong><?php echo date("g:i A", strtotime($time['open_time'])); ?></strong></td>
                                    <td><strong><?php echo date("g:i A", strtotime($time['close_time'])); ?></strong></td>
                                    <td><strong>
                                        <?php if($time['is_closed']==='0')
                                        echo "<span class='text-success'>Open<?span>";

                                        else{
                                           echo "<span class='text-danger'>Close<?span>";
                                        }
                                            ?>

                                        

                                    </strong></td>

                                </tr>
                                <?php }?>
                                <!-- <tr>
                                    <td><strong>Fri – Sat</strong></td>
                                    <td>7:00 AM – 10:00 PM</td>
                                    <td>9:00 PM</td>
                                </tr>
                                <tr>
                                    <td><strong>Sunday</strong></td>
                                    <td>8:00 AM – 5:00 PM</td>
                                    <td>4:00 PM</td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Live Search Bar -->
                <div class="faq-search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="faqSearchInput" class="faq-search-input" placeholder="Search for answers (e.g., wifi, pets, vegan)...">
                </div>

                <!-- Flat Accordion FAQ Section -->
                <div class="accordion" id="premiumCafeFaq">
                    <?php
                    $Allfaqs = allfaq();
                    $count = 1;

                    foreach ($Allfaqs as $faq) {
                    ?>
                        <div class="accordion-item faq-card">
                            <h2 class="accordion-header m-0">
                                <button class="accordion-button collapsed faq-toggle"
                                    type="button"
                                    data-target="collapse<?= $count ?>">
                                    <?php echo htmlspecialchars($faq['question']); ?>
                                </button>
                            </h2>

                            <!-- Replaced display:none with CSS Grid setup -->
                            <div id="collapse<?= $count ?>" class="accordion-content">
                                <!-- Wrapper required for smooth height calculation -->
                                <div class="accordion-body-wrapper">
                                    <div class="accordion-body">
                                        <hr style="border-color:#eaddcf; margin-top:0; margin-bottom:1rem;">
                                        <?php echo $faq['answer']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        $count++;
                    }
                    ?>

                    <div id="noFaqResults" class="text-center py-4 text-muted" style="display:none;">
                        <i class="fa-solid fa-mug-hot fs-2 mb-2" style="color: var(--cafe-gold);"></i>
                        <p>We couldn't find an answer to that question. Please contact us directly!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<footer>
    <?php include_once("footer.php"); ?>
</footer>

<!-- JavaScript for Live FAQ Search & Smooth Accordion Toggle -->
<script>
    document.addEventListener("DOMContentLoaded", function() {

        // --- 1. ACCORDION TOGGLE LOGIC ---
        const buttons = document.querySelectorAll(".faq-toggle");

        buttons.forEach(button => {
            button.addEventListener("click", function() {
                const targetId = this.getAttribute("data-target");
                const target = document.getElementById(targetId);

                // Toggle current FAQ
                if (target.classList.contains("show")) {
                    // Close this one
                    target.classList.remove("show");
                    this.classList.add("collapsed");
                } else {
                    // Close all other FAQs first
                    document.querySelectorAll(".accordion-content").forEach(item => {
                        item.classList.remove("show");
                    });

                    document.querySelectorAll(".faq-toggle").forEach(btn => {
                        btn.classList.add("collapsed");
                    });

                    // Open the clicked one
                    target.classList.add("show");
                    this.classList.remove("collapsed");
                }
            });
        });

        // --- 2. LIVE SEARCH LOGIC ---
        const searchInput = document.getElementById('faqSearchInput');

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                let filterText = this.value.toLowerCase();
                let faqItems = document.querySelectorAll('.faq-card');
                let visibleCount = 0;
                let noResultsMsg = document.getElementById('noFaqResults');

                faqItems.forEach(function(item) {
                    let text = item.textContent.toLowerCase();
                    if (text.includes(filterText)) {
                        item.style.display = "block";
                        visibleCount++;
                    } else {
                        item.style.display = "none";
                        // Also force close any open accordion items when they are hidden by search
                        const content = item.querySelector('.accordion-content');
                        const btn = item.querySelector('.faq-toggle');
                        if (content) content.classList.remove('show');
                        if (btn) btn.classList.add('collapsed');
                    }
                });

                if (visibleCount === 0) {
                    noResultsMsg.style.display = "block";
                } else {
                    noResultsMsg.style.display = "none";
                }
            });
        }

    });
</script>