<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "connection.php";
include_once("Ui-All-Function.php");

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"> -->
    <title>Delicious Cafe</title>

    <!-- External CSS -->
    <link rel="stylesheet" href="loader.css">
    <link rel="stylesheet" type="text/css" href="asset/bootstrap-5.3.7-dist/css/bootstrap.min.css">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@400;500;600&display=swap">

    <link rel="stylesheet"
        type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="stylesheet" href="media.css">
    <link href="asset/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <link rel="icon" type="image/png" href="asset/image/Gemini_Generated_Image_y86qlny86qlny86q-removebg-preview.png">
    <!-- SweetAlert2 & Animate.css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4/animate.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --orange: #f2a546;
            --yellow-border: #ffc107;
            --orange-dark: #d4870a;
            --red-soft: #ff4d6d;
            --white-glass: rgba(255, 255, 255, 0.2);
            --nav-height: 76px;
        }

        body {
            padding-top: var(--nav-height);
            font-family: 'DM Sans', sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        /* ============================================
           NAVBAR
        ============================================ */

        .navbar_area {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 76px;
            z-index: 9999;

            display: flex;
            align-items: center;

            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);

            border-bottom: 1px solid rgba(242, 165, 70, 0.15);

            transition: transform 0.45s ease,
                background 0.45s ease,
                box-shadow 0.45s ease,
                border-radius 0.45s ease;

            will-change: transform;
        }


        .navbar_area.scrolled {
            transform: translateY(10px) scale(0.95);

            background: rgba(255, 255, 255, 0.95);

            border-radius: 50px;

            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);

            border: 1.5px solid var(--yellow-border);
        }

        /* ============================================
           BRAND
        ============================================ */
        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-logo img {
            width: 55px;
            height: 55px;
            object-fit: contain;
            transition: 0.3s;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 800;
            color: var(--orange-dark);
            line-height: 1;
        }

        .brand-name span {
            display: block;
            font-family: 'DM Sans', sans-serif;
            font-size: 11px;
            font-weight: 700;
            color: #666;
            letter-spacing: 3px;
        }

        /* ============================================
           NAV LINKS
        ============================================ */
        .navbar_area .navbar-nav .nav-link {
            font-size: 17px;
            font-weight: 600;
            color: #222 !important;
            padding: 10px 20px !important;
            transition: 0.3s;
            position: relative;
        }

        .navbar_area .navbar-nav .nav-link:hover {
            color: var(--orange-dark) !important;
            transform: translateY(-2px);
        }

        /* Active Menu Item Styling */
        .navbar_area .navbar-nav .nav-link.active {
            color: var(--orange-dark) !important;
        }

        .navbar_area .navbar-nav .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 3px;
            background-color: var(--orange-dark);
            border-radius: 2px;
        }

        /* ============================================
           PROFILE & ICONS
        ============================================ */
        .avatar-img {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 3px solid var(--yellow-border);
            padding: 2px;
            background: #fff;
            /* object-fit: cover; */
            cursor: pointer;
            transition: 0.3s;
        }

        .avatar-img:hover {
            box-shadow: 0 0 15px rgba(255, 193, 7, 0.5);
            transform: scale(1.05);
        }

        .nav-icon-btn {
            font-size: 20px;
            padding: 8px;
            transition: 0.3s;
        }


        /* ============================================
           DROPDOWN
        ============================================ */
        .nav-avatar-wrap {
            position: relative;
        }

        .nav-dropdown-panel {
            display: none;
            position: absolute;
            top: 65px;
            right: 0;
            min-width: 220px;
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 193, 7, 0.2);
            z-index: 1000;
        }

        .nav-avatar-wrap.open .nav-dropdown-panel {
            display: block;
            animation: fadeInUp 0.3s ease forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ============================================
           MOBILE
        ============================================ */
        @media (max-width: 991px) {

            .navbar_area {
                height: 75px;
            }

            .brand-logo img {
                width: 45px;
                height: 45px;
            }

            .brand-name {
                font-size: 20px;
            }

            .nav-icon-btn {
                font-size: 18px;
                padding: 5px;
            }

            .avatar-img {
                width: 40px;
                height: 40px;
                border-width: 2px;
            }

            .nav-dropdown-panel {
                right: -10px;
                min-width: 200px;
            }

            /* MOBILE MENU */
            .navbar-collapse {
                position: absolute;
                top: 80px;
                left: 2.5%;
                width: 95%;
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(15px);
                border-radius: 20px;
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
                border: 1px solid var(--yellow-border);
                z-index: 1000;
                transition: all 0.35s ease;
            }

            .navbar-collapse.show {
                padding: 15px;
            }

            .navbar-collapse.collapsing {
                position: absolute !important;
                top: 80px;
                left: 2.5%;
                width: 95%;
                padding: 0 15px;
            }

            .navbar-nav {
                text-align: center;
            }

            .nav-link {
                padding: 12px !important;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            }

            .nav-link:last-child {
                border-bottom: none;
            }

            /* Hide the active indicator dot on mobile to keep it clean */
            .navbar_area .navbar-nav .nav-link.active::after {
                display: none;
            }

        }

        /* Basic button style (isolated to the fm-action-btn class to prevent conflicts) */
        a.fm-action-btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            padding: 10px 20px !important;
            border-radius: 30px !important;
            font-size: 15px !important;
            font-weight: 600 !important;
            text-decoration: none !important;
            transition: all 0.3s ease-in-out !important;
            border: none !important;
        }

        /* Order button styling with hover effects */
        a.fm-order-btn {
            background: linear-gradient(135deg, #a95103 0%, #5a2a02 100%);
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(248, 210, 140, 0.5) !important;
        }

        a.fm-order-btn:hover {
            box-shadow: 0 4px 15px rgba(251, 208, 128, 0.5) !important;
        }

        /* Remove button styling with hover effects */
        a.fm-remove-btn {
            background: linear-gradient(135deg, #ff416c, #f01e4f) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(255, 75, 43, 0.3) !important;
        }

        a.fm-remove-btn:hover {
            transform: translateY(-3px) scale(1.02) !important;
            box-shadow: 0 6px 20px rgba(255, 75, 43, 0.5) !important;
        }

        /* Smooth scale animation for the icons on hover */
        a.fm-action-btn:hover i {
            transform: scale(1.1) !important;
            transition: transform 0.2s !important;
        }

        /* Full-screen white overlay */

       /* Soft, warm background */
#loader-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: #FDFBF7; /* A warm cream color */
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: opacity 0.6s ease, visibility 0.6s ease;
}

.loader-content {
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* --- The Coffee Cup --- */
.cup-container {
    position: relative;
    width: 80px;
    height: 90px;
    margin-bottom: 20px;
}

.solid-cup {
    position: absolute;
    bottom: 0;
    left: 10px;
    width: 60px;
    height: 50px;
    background-color: #4A3B32; /* Rich Espresso Brown */
    border-radius: 5px 5px 25px 25px;
    z-index: 2;
}

.solid-cup-handle {
    position: absolute;
    bottom: 15px;
    right: 0px;
    width: 25px;
    height: 25px;
    border: 5px solid #4A3B32;
    border-radius: 50%;
    z-index: 1;
}

/* --- The Rising Steam --- */
.steam {
    position: absolute;
    bottom: 55px;
    width: 6px;
    height: 25px;
    background-color: #D3C5B8;
    border-radius: 10px;
    opacity: 0;
    animation: rise 2s infinite ease-in;
}

.steam-1 { left: 25px; animation-delay: 0s; }
.steam-2 { left: 40px; animation-delay: 0.6s; }
.steam-3 { left: 55px; animation-delay: 1.2s; }

@keyframes rise {
    0% { transform: translateY(0) scale(1); opacity: 0; }
    50% { opacity: 0.7; }
    100% { transform: translateY(-30px) scale(1.5); opacity: 0; }
}

/* --- Typography --- */
#loader-text {
    font-family: 'Helvetica Neue', Arial, sans-serif;
    color: #4A3B32;
    font-size: 16px;
    font-weight: 500;
    margin-bottom: 15px;
    letter-spacing: 1px;
    transition: opacity 0.3s ease;
}

/* --- The Loading Bar --- */
.loading-bar-container {
    width: 150px;
    height: 4px;
    background-color: #EBE3DB;
    border-radius: 10px;
    overflow: hidden;
}

.loading-bar {
    width: 0%;
    height: 100%;
    background-color: #C08B5C; /* Caramel accent color */
    border-radius: 10px;
    animation: fill-bar 2s ease-in-out forwards;
}

@keyframes fill-bar {
    0% { width: 0%; }
    50% { width: 70%; }
    100% { width: 100%; }
}

/* Fade out class for JavaScript */
.fade-out {
    opacity: 0;
    visibility: hidden;
}




/* view more button */

/* =========================================
   Option 1: Solid Coffee Button
   ========================================= */
.cafe-view-more-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #36241C; 
    color: #ffffff;
    text-decoration: none;
    padding: 12px 32px;
    font-size: 15px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    border-radius: 50px; 
    transition: all 0.3s ease;
    border: 2px solid #36241C;
    box-shadow: 0 4px 10px rgba(54, 36, 28, 0.2);
}

.cafe-view-more-btn:hover {
    background-color: #BD7753;
    border-color: #BD7753;
    color: #ffffff;
    transform: translateY(-3px); 
    box-shadow: 0 8px 20px rgba(189, 119, 83, 0.3);
}

/* =========================================
   Option 2: Elegant Outline Button
   ========================================= */

.cafe-outline-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: transparent;
    color: #BD7753;
    text-decoration: none;
    padding: 12px 32px;
    font-size: 15px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    border-radius: 50px;
    border: 2px solid #BD7753;
    position: relative;
    overflow: hidden; 
    z-index: 1;
    
    transition: color 0.4s ease, transform 0.4s ease, box-shadow 0.4s ease;
}


.cafe-outline-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #BD7753;
    z-index: -1;
    transform: scaleX(0); 
    transform-origin: left;
    transition: transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    border-radius: 50px;
}


.cafe-outline-btn:hover {
    color: #ffffff; 
    transform: translateY(-4px); 
    box-shadow: 0 10px 25px rgba(189, 119, 83, 0.4); 
}


.cafe-outline-btn:hover::before {
    transform: scaleX(1); 
}


.cafe-outline-btn:active {
    transform: translateY(-1px) scale(0.98);
    box-shadow: 0 5px 15px rgba(189, 119, 83, 0.3);
}

/* ============================================
   CUSTOM STYLISH LOGOUT MODAL
============================================ */
.cafe-logout-popup {
    background: #ffffff !important;
    border-radius: 24px !important;
    padding: 32px 24px 28px !important;
    border: 1px solid rgba(193, 140, 93, 0.22) !important;
    box-shadow: 0 24px 60px rgba(54, 34, 28, 0.22), 0 8px 24px rgba(0, 0, 0, 0.06) !important;
    font-family: 'DM Sans', sans-serif !important;
    max-width: 430px !important;
}

.cafe-logout-title {
    font-family: 'Playfair Display', Georgia, serif !important;
    font-size: 1.65rem !important;
    font-weight: 700 !important;
    color: #36221c !important;
    margin-top: 12px !important;
    margin-bottom: 8px !important;
    line-height: 1.2 !important;
}

.cafe-logout-icon-wrap {
    width: 76px;
    height: 76px;
    margin: 0 auto 10px;
    border-radius: 50%;
    background: #fff0f3;
    border: 3px solid #ffccd5;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #e63946;
    font-size: 2rem;
    box-shadow: 0 6px 18px rgba(230, 57, 70, 0.15);
    animation: pulseSoft 2s infinite;
}

@keyframes pulseSoft {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 6px 18px rgba(230, 57, 70, 0.15);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 8px 24px rgba(230, 57, 70, 0.25);
    }
}

.cafe-logout-actions {
    display: flex !important;
    justify-content: center !important;
    gap: 12px !important;
    margin-top: 24px !important;
    width: 100% !important;
}

.cafe-logout-confirm-btn {
    background: linear-gradient(135deg, #e63946 0%, #c92a2a 100%) !important;
    color: #ffffff !important;
    font-size: 0.95rem !important;
    font-weight: 600 !important;
    padding: 12px 24px !important;
    border-radius: 50px !important;
    border: none !important;
    box-shadow: 0 6px 18px rgba(230, 57, 70, 0.35) !important;
    cursor: pointer !important;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    text-decoration: none !important;
}

.cafe-logout-confirm-btn:hover {
    background: linear-gradient(135deg, #d90429 0%, #a01a1a 100%) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 24px rgba(230, 57, 70, 0.45) !important;
    color: #ffffff !important;
}

.cafe-logout-confirm-btn:active {
    transform: translateY(0) !important;
}

.cafe-logout-cancel-btn {
    background: #f4ede4 !important;
    color: #5c524f !important;
    font-size: 0.95rem !important;
    font-weight: 600 !important;
    padding: 12px 22px !important;
    border-radius: 50px !important;
    border: 1px solid #e2d6c7 !important;
    cursor: pointer !important;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
}

.cafe-logout-cancel-btn:hover {
    background: #e8ded2 !important;
    color: #36221c !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 12px rgba(54, 34, 28, 0.08) !important;
}

.cafe-logout-cancel-btn:active {
    transform: translateY(0) !important;
}

/* Generic Cafe Alert & Confirm Modals */
.cafe-alert-popup {
    background: #ffffff !important;
    border-radius: 24px !important;
    padding: 30px 24px 26px !important;
    border: 1px solid rgba(193, 140, 93, 0.22) !important;
    box-shadow: 0 20px 60px rgba(54, 34, 28, 0.2) !important;
    font-family: 'DM Sans', sans-serif !important;
    max-width: 430px !important;
}

.cafe-alert-title {
    font-family: 'Playfair Display', Georgia, serif !important;
    font-size: 1.6rem !important;
    font-weight: 700 !important;
    color: #36221c !important;
    margin-top: 10px !important;
    margin-bottom: 8px !important;
}

.cafe-alert-btn {
    background: linear-gradient(135deg, #c18c5d 0%, #36221c 100%) !important;
    color: #ffffff !important;
    font-size: 0.95rem !important;
    font-weight: 600 !important;
    padding: 11px 28px !important;
    border-radius: 50px !important;
    border: none !important;
    box-shadow: 0 4px 15px rgba(54, 34, 28, 0.2) !important;
    cursor: pointer !important;
    transition: all 0.25s ease !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    margin-top: 12px !important;
    text-decoration: none !important;
}

.cafe-alert-btn:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 20px rgba(54, 34, 28, 0.3) !important;
    color: #ffffff !important;
}
    </style>
</head>

<body>
    <!-- loader -->
   <div id="loader-wrapper">
    <div class="loader-content">
        <!-- Animated Cup and Steam -->
        <div class="cup-container">
            <div class="steam steam-1"></div>
            <div class="steam steam-2"></div>
            <div class="steam steam-3"></div>
            <div class="solid-cup"></div>
            <div class="solid-cup-handle"></div>
        </div>
        
        <!-- Changing Text -->
        <h2 id="loader-text">Waking up the barista...</h2>
        
        <!-- Progress Bar -->
        <div class="loading-bar-container">
            <div class="loading-bar"></div>
        </div>
    </div>
</div>
    <!-- NAVBAR -->
    <div class="navbar_area" id="mainNavbar">

        <nav class="navbar navbar-expand-lg w-100 px-3 px-lg-5">

            <div class="container-fluid px-0 position-relative">

                <!-- LOGO -->
                <a class="brand-logo" href="index.php">

                    <img src="asset/image/Gemini_Generated_Image_y86qlny86qlny86q-removebg-preview.png" alt="Delicious">

                    <div class="brand-name">
                        Delicious
                        <span>CAFE</span>
                    </div>

                </a>

                <!-- RIGHT ICONS -->
                <div class="d-flex align-items-center gap-2 gap-lg-3 ms-auto me-2 me-lg-0 order-lg-last">

                    <!-- CART -->
                    <button class="nav-icon-btn border-0 bg-transparent text-warning position-relative">

                        <a href="history.php" class="text-warning"><i class="fa-solid fa-clock-rotate-left"></i></a>



                    </button>

                    <!-- HEART -->

                    <span class="position-relative d-inline-block" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#favoriteOffcanvas" aria-controls="favoriteOffcanvas">

                        <i class="fas fa-heart text-danger fs-4"></i>

                        <span class="position-absolute start-100 translate-middle  favorite-icon bg-white border border-danger text-danger" id="favCount" style="font-size: 0.60rem; top: -5px !important;">
                            <?php echo total_favorite_item(); ?>
                        </span>
                    </span>


                    <!-- PROFILE -->
                    <?php if (isset($_SESSION['eid'])) { ?>

                        <div class="nav-avatar-wrap " id="avatarWrap">

                            <img
                                class="avatar-img border-info"
                                id="avatarToggle"
                                src="upload/<?php echo !empty($_SESSION['photo'])
                                                ? htmlspecialchars($_SESSION['photo'])
                                                : 'profile.png'; ?>"
                                alt="Profile">

                            <div class="nav-dropdown-panel">

                                <h6 class="mb-0 fw-bold">
                                    <?php echo htmlspecialchars($_SESSION['username']); ?>
                                </h6>

                                <small class="text-muted">
                                    Customer of The Cafe
                                </small>

                                <hr class="my-2">

                                <a href="profile.php" class="dropdown-item py-2">
                                    <i class="fa-solid fa-user-gear me-2"></i>
                                    My Profile
                                </a>

                                <a href="logout.php"
                                    class="dropdown-item py-2 text-danger"
                                    onclick="return confirmLogout(event, this.href)">

                                    <i class="fa-solid fa-power-off me-2"></i>
                                    Logout

                                </a>

                            </div>

                        </div>

                    <?php } else {
                    ?>

                        <a href="Login_form.php" class="ms-1 ms-lg-2">

                            <img src="asset/image/profile.png"
                                class="avatar-img "
                                alt="Login">

                        </a>

                    <?php } ?>

                </div>

                <!-- TOGGLER -->
                <button class="navbar-toggler border-0 shadow-none p-1"
                    type="button">

                    <i class="fa-solid fa-bars fs-3 text-dark"></i>

                </button>

                <!-- MENU -->
                <div class="collapse navbar-collapse" id="navbarMain">

                    <ul class="navbar-nav mx-auto">

                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'about_us.php') ? 'active' : ''; ?>" href="about_us.php">About</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'menu.php') ? 'active' : ''; ?>" href="menu.php">Menu</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'table_book.php') ? 'active' : ''; ?>" href="table_book.php">Booking</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'contact_us.php') ? 'active' : ''; ?>" href="contact_us.php">Contact</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'history.php') ? 'active' : ''; ?>" href="history.php">history</a>
                        </li> -->

                        <li class="nav-item ms-lg-2">
                            <a class="nav-link faq-link text-warning fw-bold <?php echo ($current_page == 'faq.php') ? 'active' : ''; ?>"
                                href="faq.php">
                                <i class="fa-regular fa-circle-question me-1"></i>
                                FAQ
                            </a>
                        </li>

                    </ul>

                </div>

            </div>

        </nav>

    </div>





    <!-- Offcanvas Element -->
    <div class="offcanvas offcanvas-end" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" id="favoriteOffcanvas" aria-labelledby="favoriteOffcanvasLabel">

        <!-- Custom Cafe Header -->
        <div class="offcanvas-header offcanvas-cafe-header px-4 py-3">
            <h5 class="offcanvas-title fw-bold" id="favoriteOffcanvasLabel">
                <i class="fas fa-heart" style="color: #fa3e3e;"></i> My Favorites
            </h5>
            <!-- The Close Button (Only this will close the offcanvas) -->
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>


        <!-- Body (Favorite Items List) -->


        <div class="offcanvas-body px-3 py-4" id="favoriteItemsContainer">

            <?php
            if (isset($_SESSION['id'])) {
                $favorite_all_items = all_favorite_item();
                if (!empty($favorite_all_items)) {
                    foreach ($favorite_all_items as $items) {
                        $single_menu = single_row_details('products', $items['product_id']);
                        if ($single_menu) {
            ?>
                    <div class="card cafe-fav-card mb-3 shadow-sm" data-product-id="<?php echo (int)$single_menu['id']; ?>">
                        <div class="row g-0 align-items-center h-100 w-75">
                            <div class="col-4 h-100">
                                <img src="upload/<?php echo htmlspecialchars($single_menu['image']); ?>" style="height: 15vh; width:100%;" alt="<?php echo htmlspecialchars($single_menu['name']); ?>">
                            </div>
                            <div class="col-8">
                                <div class="card-body py-2 px-3">
                                    <h6 class="card-title fw-bold mb-1 text-dark">Item : <?php echo htmlspecialchars($single_menu['name']); ?></h6>
                                    <p class="card-text fw-bold text-cafe-price mb-2">Rs : <?php echo htmlspecialchars($single_menu['price']); ?></p>
                                    <div class="d-flex gap-2 align-items-center">
                                        <!-- Order Button -->
                                        <a href="order_page.php?id=<?php echo (int)$single_menu['id']; ?>&btn=order" class="fm-action-btn fm-order-btn font-sans">
                                            <i class="fa-solid fa-cart-shopping"></i> Order
                                        </a>

                                        <!-- Remove Button -->
                                        <a href="Ui-All-Function.php?pid=<?php echo (int)$single_menu['id']; ?>&btn=remove" class="fm-action-btn fm-remove-btn fav-remove-btn font-sans" data-product-id="<?php echo (int)$single_menu['id']; ?>" title="Remove from Favorites">
                                            <i class="fa-solid fa-trash-can"></i> Remove
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                        }
                    }
                } else {
                ?>
                    <div class="card cafe-fav-card mb-3 shadow-sm empty-fav-msg">
                        <div class="row g-0 align-items-center h-100">
                            <h3 class="text-center p-2">No items Added</h3>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="card cafe-fav-card mb-3 shadow-sm empty-fav-msg">
                    <div class="row g-0 align-items-center h-100">
                        <h3 class="text-center p-2">No items Added</h3>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>



    <!-- JS -->
    <script src="asset/bootstrap-5.3.7-dist/js/jquery.min.js"></script>
    <script src="asset/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>

    <script>
        //    ajex function diya favorite list call
        function loadFavorites() {
            $.ajax({
                url: 'get_favorites.php',
                type: 'GET',
                success: function(response) {

                    $('#favoriteItemsContainer').html(response);

                    let count = $('#favoriteItemsContainer .cafe-fav-card:not(.empty-fav-msg)').length;
                    $('#favCount').text(count);
                },
                error: function() {
                    console.log("Error loading favorites.");
                }
            });
        }


        $('#favoriteOffcanvas').on('show.bs.offcanvas', function() {
            loadFavorites();
        });


        document.addEventListener("DOMContentLoaded", function() {
            var offcanvas = document.getElementById('favoriteOffcanvas');

            if (offcanvas) {
                // Apply smooth transition for both margin-top and transform (sliding)
                offcanvas.style.setProperty('transition', 'margin-top 0.3s ease-in-out, transform 0.3s ease-in-out', 'important');

                // Scroll event listener
                window.addEventListener('scroll', function() {

                    // If the page is scrolled more than 50 pixels
                    if (window.scrollY > 50) {

                        // Check the screen width for responsiveness
                        if (window.innerWidth < 768) {
                            // For mobile and tablet screens (less than 768px)
                            offcanvas.style.marginTop = "2vh"; /* You can also use "10px" here if you prefer */
                            offcanvas.style.marginRight = "2vh";
                        } else {
                            // For desktop screens
                            offcanvas.style.marginTop = "3vh";
                            offcanvas.style.marginRight = "5vh";
                        }

                    } else {
                        // Reset margin to 0px when scrolled back to the very top
                        offcanvas.style.marginTop = "0px";
                        offcanvas.style.marginRight = "0vh";
                    }
                });
            }
        });


        // ajex function diya favorite list call end




        // favorite list call end
        // NAVBAR SCROLL
        window.addEventListener('scroll', function() {

            const nav = document.getElementById('mainNavbar');

            if (window.scrollY > 60) {

                nav.classList.add("scrolled");

            } else {

                nav.classList.remove("scrolled");
            }

        });

        // PROFILE DROPDOWN
        const avatarWrap = document.getElementById('avatarWrap');
        const avatarToggle = document.getElementById('avatarToggle');

        if (avatarToggle) {

            avatarToggle.addEventListener('click', function(e) {

                e.stopPropagation();

                avatarWrap.classList.toggle('open');

            });

            document.addEventListener('click', () => {

                avatarWrap.classList.remove('open');

            });

        }

        // ============================
        // HAMBURGER ICON TOGGLE
        // ============================

        const navbarCollapse = document.getElementById('navbarMain');

        const navbarToggler = document.querySelector('.navbar-toggler');

        const togglerIcon = navbarToggler.querySelector('i');

        // Bootstrap Collapse Instance
        const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
            toggle: false
        });

        // Toggle Button Click
        navbarToggler.addEventListener('click', function() {

            if (navbarCollapse.classList.contains('show')) {

                // CLOSE MENU
                bsCollapse.hide();

                togglerIcon.classList.remove('fa-xmark');
                togglerIcon.classList.add('fa-bars');

            } else {

                // OPEN MENU
                bsCollapse.show();

                togglerIcon.classList.remove('fa-bars');
                togglerIcon.classList.add('fa-xmark');

            }

        });

        // Auto close after clicking nav link
        document.querySelectorAll('#navbarMain .nav-link').forEach(link => {

            link.addEventListener('click', () => {

                bsCollapse.hide();

                togglerIcon.classList.remove('fa-xmark');
                togglerIcon.classList.add('fa-bars');

            });

        });



        // STYLISH LOGOUT CONFIRM
        function confirmLogout(e, url) {
            if (e) {
                e.preventDefault();
            }

            if (typeof Swal === 'undefined') {
                if (confirm('Do you really want to sign out?')) {
                    window.location.href = url;
                }
                return false;
            }

            Swal.fire({
                html: `
                    <div class="cafe-logout-icon-wrap">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </div>
                    <h3 class="cafe-logout-title">Ready to Leave?</h3>
                    <p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.5;">Are you sure you want to sign out of Delicious Cafe?</p>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="fa-solid fa-power-off me-2"></i>Yes, Log Out',
                cancelButtonText: '<i class="fa-solid fa-xmark me-2"></i>Stay Logged In',
                reverseButtons: true,
                focusCancel: true,
                buttonsStyling: false,
                backdrop: 'rgba(44, 24, 16, 0.45)',
                customClass: {
                    popup: 'cafe-logout-popup',
                    confirmButton: 'cafe-logout-confirm-btn',
                    cancelButton: 'cafe-logout-cancel-btn',
                    actions: 'cafe-logout-actions'
                },
                showClass: {
                    popup: 'animate__animated animate__zoomIn animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        html: `
                            <div class="cafe-logout-icon-wrap" style="background:#e8f5e9; border-color:#a5d6a7; color:#2e7d32; animation:none;">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <h3 class="cafe-logout-title" style="color:#2e7d32;">Logging Out...</h3>
                            <p class="text-muted mb-0" style="font-size: 0.95rem;">Have a wonderful day! See you soon.</p>
                        `,
                        showConfirmButton: false,
                        timer: 900,
                        backdrop: 'rgba(44, 24, 16, 0.45)',
                        customClass: {
                            popup: 'cafe-logout-popup'
                        },
                        willClose: () => {
                            window.location.href = url;
                        }
                    });
                    setTimeout(() => {
                        window.location.href = url;
                    }, 850);
                }
            });

            return false;
        }
    </script>
    <!-- SweetAlert2 for Guest Prompts and Universal Cafe Alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Universal Custom Cafe Alert
        function cafeAlert(title, message, icon = 'info', redirectUrl = null) {
            let iconColor = '#c18c5d';
            if (icon === 'success') iconColor = '#2a9d8f';
            else if (icon === 'error') iconColor = '#e63946';
            else if (icon === 'warning') iconColor = '#e79006';

            return Swal.fire({
                title: title,
                html: `<p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.5;">${message}</p>`,
                icon: icon,
                iconColor: iconColor,
                confirmButtonText: 'OK',
                buttonsStyling: false,
                backdrop: 'rgba(44, 24, 16, 0.45)',
                customClass: {
                    popup: 'cafe-alert-popup animate__animated animate__zoomIn animate__faster',
                    title: 'cafe-alert-title',
                    confirmButton: 'cafe-alert-btn'
                }
            }).then((result) => {
                if (redirectUrl && (result.isConfirmed || result.isDismissed)) {
                    window.location.href = redirectUrl;
                }
                return result;
            });
        }

        // Universal Custom Cafe Confirm Dialog
        function cafeConfirm(title, message, confirmText = 'Yes, Proceed', cancelText = 'Cancel', icon = 'warning') {
            let iconColor = (icon === 'warning' || icon === 'error') ? '#e63946' : '#c18c5d';
            return Swal.fire({
                title: title,
                html: `<p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.5;">${message}</p>`,
                icon: icon,
                iconColor: iconColor,
                showCancelButton: true,
                confirmButtonText: confirmText,
                cancelButtonText: cancelText,
                reverseButtons: true,
                focusCancel: true,
                buttonsStyling: false,
                backdrop: 'rgba(44, 24, 16, 0.45)',
                customClass: {
                    popup: 'cafe-alert-popup animate__animated animate__zoomIn animate__faster',
                    title: 'cafe-alert-title',
                    confirmButton: 'cafe-logout-confirm-btn',
                    cancelButton: 'cafe-logout-cancel-btn',
                    actions: 'cafe-logout-actions'
                }
            });
        }

        function showGuestAlert(actionName) {
            Swal.fire({
                title: 'Sign In Required',
                text: 'Please sign in to ' + actionName + '!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d4870a',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sign In Now',
                cancelButtonText: 'Cancel',
                background: '#faf8f5',
                backdrop: 'rgba(44, 24, 16, 0.45)',
                customClass: {
                    title: 'fw-bold text-dark font-serif',
                    popup: 'cafe-alert-popup animate__animated animate__zoomIn animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'Login_form.php';
                }
            });
        }
    </script>