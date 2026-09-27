<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delicious Cafe</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Google Fonts (Playfair Display for headings, Poppins for body) -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="asset/image/Gemini_Generated_Image_y86qlny86qlny86q-removebg-preview.png">

    <style>
        /* Base Typography */
        body {
            font-family: 'Poppins', sans-serif;
            color: #4a4a4a;
            line-height: 1.7;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Playfair Display', serif;
            color: #2c1e16;
        }

        /* Color Palette */
        .brand-text {
            color: #d4a373;
            /* Warm latte/caramel color */
        }

        .bg-coffee-dark {
            background-color: #2c1e16;
            color: #f8f9fa;
        }

        .bg-coffee-light {
            background-color: #fdf8f5;
        }

        /* Hero Section with Parallax Effect */
        .hero-section {
            background: linear-gradient(rgba(44, 30, 22, 0.8), rgba(44, 30, 22, 0.6)), url('asset/image/about-us-banner.avif') center/cover no-repeat;
            background-attachment: fixed;
            /* Creates the parallax scrolling effect */
            padding: 150px 0;
            color: white;
            position: relative;
        }

        .hero-section h1 {
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Card Customizations & Hover Effects */
        .card-hover {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-radius: 20px;
            background: #ffffff;
        }

        .card-hover:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(212, 163, 115, 0.15) !important;
            border-color: #d4a373 !important;
        }

        /* Icon Circles with Pulse Effect */
        .icon-circle {
            width: 85px;
            height: 85px;
            background-color: #fff3e3;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            color: #d4a373;
            transition: all 0.4s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .card-hover:hover .icon-circle {
            background-color: #d4a373;
            color: white;
            transform: scale(1.1);
            box-shadow: 0 10px 20px rgba(212, 163, 115, 0.4);
        }

        /* Image Styling */
        .story-img {
            border-radius: 24px;
            border: 10px solid white;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: transform 0.5s ease;
        }

        .story-img:hover {
            transform: scale(1.02);
        }

        /* Section Subtitles */
        .section-subtitle {
            font-size: 0.9rem;
            letter-spacing: 2px;
            font-weight: 600;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Navigation Bar (Included via PHP) -->
    <?php include_once('header.php') ?>

    <!-- Hero Header Section -->
    <section class="hero-section text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-2 fw-bold mb-3">About <span class="brand-text">Delicious</span></h1>
                    <p class="lead text-light fs-4 fw-light">A haven where the perfect roast meets a welcoming community.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Wrapper -->
    <main class="flex-grow-1">

        <!-- Our Story Section -->
        <section class="py-5 bg-coffee-light">
            <div class="container py-5">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-5 mb-md-0 pe-md-5">
                        <h6 class="brand-text section-subtitle text-uppercase mb-3 fs-5">Discover Our Roots</h6>
                        <h2 class="display-5 fw-bold mb-4">A Pure Passion for Coffee</h2>
                        <p class="fs-5 text-muted mb-4 " style="text-align: justify;">The idea for Delicious was born out of a singular,love for exceptional coffee. We set out to create a sanctuary where aficionados and casual drinkers alike could gather to experience the true art of the brew. We set out to create a sanctuary where aficionados and casual drinkers alike could gather to experience the true art of the brew.</p>
                        <p class="text-muted fs-5" style="text-align: justify;">We don't distract ourselves with a sprawling menu. Instead, we pour 100% of our focus into sourcing, roasting, and extracting the perfect cup. From the rich crema of our espresso to the delicate notes of our pour-overs, every drop is crafted with absolute precision.</p>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="asset/image/about-img.png" alt="Barista pouring latte art" class="img-fluid story-img">
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Delicious Section -->
        <section class="py-5 bg-coffee-dark text-center">
            <div class="container py-5">
                <h6 class="brand-text section-subtitle text-uppercase mb-3">The Delicious Difference</h6>
                <h2 class="display-5 fw-bold text-white mb-5">Why Choose Us?</h2>

                <div class="row justify-content-center">
                    <!-- Point 1: Quality Coffee -->
                    <div class="col-md-4 mb-4">
                        <div class="p-4 h-100 rounded-4" style="background: rgba(255,255,255,0.03);">
                            <i class="fa-solid fa-seedling fa-3x brand-text mb-4"></i>
                            <h3 class="text-white h4 mb-3">Single-Origin Quality</h3>
                            <p class="text-light opacity-75">We source only the finest, ethically grown beans from around the world, small-batch roasted to highlight their unique flavor profiles.</p>
                        </div>
                    </div>

                    <!-- Point 2: Online Order -->
                    <div class="col-md-4 mb-4">
                        <div class="p-4 h-100 rounded-4" style="background: rgba(255,255,255,0.03);">
                            <i class="fa-solid fa-mobile-screen-button fa-3x brand-text mb-4"></i>
                            <h3 class="text-white h4 mb-3">Easy Online Ordering</h3>
                            <p class="text-light opacity-75">Need your caffeine fix in a hurry? Use our seamless online system to order your custom brew, skip the line, and grab it on the go.</p>
                        </div>
                    </div>

                    <!-- Point 3: Always Open -->
                    <div class="col-md-4 mb-4">
                        <div class="p-4 h-100 rounded-4" style="background: rgba(255,255,255,0.03);">
                            <i class="fa-solid fa-door-open fa-3x brand-text mb-4"></i>
                            <h3 class="text-white h4 mb-3">Always Open</h3>
                            <p class="text-light opacity-75">Whether you need a 6 AM jumpstart before work or a late-night Americano for a study session, our doors and espresso machines are always running.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- What We Offer Section (Coffee Only) -->
        <section class="py-5 bg-coffee-light">
            <div class="container py-5">
                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <h6 class="brand-text section-subtitle text-uppercase mb-3">Our Craft</h6>
                        <h2 class="display-5 fw-bold">The Coffee Experience</h2>
                    </div>
                </div>

                <div class="row ">
                    <!-- Offer 1: Espresso -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border border-light shadow-sm text-center card-hover p-4">
                            <div class="card-body">
                                <div class="icon-circle mb-4">
                                    <i class="fa-solid fa-mug-saucer fa-2x"></i>
                                </div>
                                <h4 class="card-title fw-bold">The Espresso Bar</h4>
                                <p class="card-text text-muted mt-3">Rich, bold, and crafted to perfection. Enjoy our signature house blend tailored into flawless Macchiatos, Cappuccinos, and Flat Whites.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Offer 2: Manual Brews -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border border-light shadow-sm text-center card-hover p-4">
                            <div class="card-body">
                                <div class="icon-circle mb-4">
                                    <i class="fa-solid fa-filter fa-2x"></i>
                                </div>
                                <h4 class="card-title fw-bold">Artisan Pour-Overs</h4>
                                <p class="card-text text-muted mt-3">For the true aficionado. Experience the delicate, complex tasting notes of our single-origin beans through precise V60 and Chemex brewing.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Offer 3: Cold Brews -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border border-light shadow-sm text-center card-hover p-4">
                            <div class="card-body">
                                <div class="icon-circle mb-4">
                                    <i class="fa-solid fa-glass-water fa-2x"></i>
                                </div>
                                <h4 class="card-title fw-bold">Signature Cold Brews</h4>
                                <p class="card-text text-muted mt-3">Slow-steeped in-house for 24 hours to eliminate acidity, resulting in a perfectly smooth, refreshing, and highly caffeinated finish.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Commitment Section -->
        <section class="py-2 bg-coffee-light">
            <div class="container py-5">
                <div class="row text-center justify-content-center">
                    <div class="col-lg-8 p-5 bg-white shadow rounded-4" style="border-top: 5px solid #d4a373;">
                        <i class="fa-solid fa-mug-hot fa-2x brand-text mb-3"></i>
                        <h2 class="mb-4 fw-bold">Our Commitment</h2>
                        <p class="fs-5 text-muted mb-4">We believe that a great cup of coffee can change your entire day. Our baristas are meticulously trained to ensure every beverage we serve meets our uncompromising standards. Whether you're here to catch up with a friend, read a book, or simply enjoy a moment of peace in our space, we strive to make every visit memorable.</p>
                        <h4 class="mt-4 fw-bold brand-text">Thank you for choosing Delicious. Let's brew something great!</h4>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="mt-4">
        <?php include_once('footer.php') ?>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>