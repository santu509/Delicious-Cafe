<?php
// Start the session (if not already started)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the admin is logged in
if (!isset($_SESSION['admin_name'])) {
    // Redirect to the login page if not logged in. 
    // (If your login page is not named login.php, update the name here)
    header("Location: index.php"); 
    exit();
}

include('admin_login.php');

$Admin_name = $_SESSION['admin_name'];
$Admin_photo = isset($_SESSION['admin_image']) ? $_SESSION['admin_image'] : '../asset/image/admin.jpg';

// Get the current page name to apply the active class
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delicious Cafe Dashboard</title>

    <link rel="stylesheet" type="text/css" href="../asset/bootstrap-5.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="Dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="icon" type="image/png" href="../asset/image/Gemini_Generated_Image_y86qlny86qlny86q-removebg-preview.png">

    <!-- SweetAlert2 & Animate.css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4/animate.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Active Class styling (You can also move this to your Dashboard.css file) -->
    <style>
        .menu-list a.active {
            background-color: #502805; /* You can change the color according to your cafe's theme */
            color: #ffffff !important;
            font-weight: 700;
            border-radius: 8px;
            padding-left: 15px; /* Shift slightly to the right for better UI */
            transition: all 0.3s ease;
        }

        .admin-delete-popup {
            background: #ffffff !important;
            border-radius: 20px !important;
            padding: 28px 24px !important;
            border: 1px solid #ebdcc8 !important;
            box-shadow: 0 20px 50px rgba(50, 24, 5, 0.25) !important;
            font-family: inherit !important;
            max-width: 420px !important;
        }

        .admin-delete-title {
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            color: #361b04 !important;
            margin-top: 10px !important;
        }
    </style>
</head>

<body>

    <div class="mobile-nav d-lg-none p-3 position-fixed" style="z-index: 1060;">
        <button id="sidebarToggle" class="btn btn-warning shadow-sm">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <div class="main">
        <div class="Dashboard-left">
            <div class="left-bar text-center">

                <div class="cafe_logo">
                    <img src="../asset/image/Gemini_Generated_Image_y86qlny86qlny86q-removebg-preview.png" alt="Cafe Logo">
                    <p class="Cafe-name">The Cafe Dashboard Of Delicious</p>
                </div>

                <ul class="menu-list">
                    <!-- The 'active' class will be added if the current page matches the link -->
                    <li><a href="banner-revineu.php" class="dashboard-list-style <?= ($current_page == 'banner-revineu.php') ? 'active' : ''; ?>">Dashboard</a></li>
                    <li><a href="orders.php" class="dashboard-list-style <?= ($current_page == 'orders.php') ? 'active' : ''; ?>">Orders</a></li>
                    <li><a href="Table_Book.php" class="dashboard-list-style <?= ($current_page == 'Table_Book.php') ? 'active' : ''; ?>">Table Book</a></li>
                    <li><a href="product-list.php" class="dashboard-list-style <?= ($current_page == 'product-list.php') ? 'active' : ''; ?>">Menu</a></li>
                    <li><a href="category.php" class="dashboard-list-style <?= ($current_page == 'category.php') ? 'active' : ''; ?>">Category</a></li>
                    <li><a href="user_list.php" class="dashboard-list-style <?= ($current_page == 'user_list.php') ? 'active' : ''; ?>">Customer</a></li>
                    <li><a href="faq_page.php" class="dashboard-list-style <?= ($current_page == 'faq_page.php') ? 'active' : ''; ?>">FAQ</a></li>
                    <li>
                        <a href="admin-logout.php" class="dashboard-list-style logout-btn logout-icon">
                            <i class="fa fa-sign-out icon me-2" style="font-size:14px;"></i>Logout
                        </a>
                    </li>
                </ul>

                <div class="admin-part">
                    <div class="admin_img d-flex align-items-center">
                        <img src="<?= $Admin_photo; ?>" alt="Admin Image" onerror="this.src='../asset/image/admin.jpg'">
                        <div class="ms-2 text-start">
                           
                            <p class="cafe-title m-0">Owner Of The Cafe</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.Dashboard-left');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active'); 
                
                const icon = sidebarToggle.querySelector('i');
                if (sidebar.classList.contains('active')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
        });

        // Admin Custom Delete Confirmation
        function confirmAdminDelete(e, url, itemName = 'this item') {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }

            if (typeof Swal === 'undefined') {
                if (confirm('Are you sure you want to delete ' + itemName + '?')) {
                    window.location.href = url;
                }
                return false;
            }

            Swal.fire({
                title: 'Are you sure?',
                html: '<p style="color: #6c757d; font-size: 0.95rem; margin-top: 5px; margin-bottom: 0;">Do you really want to delete <b>' + itemName + '</b>?<br><span style="font-size: 0.85rem; color: #dc3545; display: inline-block; margin-top: 6px;">This action cannot be undone!</span></p>',
                icon: 'warning',
                iconColor: '#e63946',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-trash me-1"></i> Yes, Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                reverseButtons: true,
                focusCancel: true,
                backdrop: 'rgba(50, 24, 5, 0.45)',
                customClass: {
                    popup: 'rounded-4 shadow-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });

            return false;
        }
    </script>
</body>

</html> 