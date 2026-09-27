<?php
include 'header.php';
include_once('Ui-All-Function.php');
?>

<!-- =========================
     BANNER SECTION START
========================= -->
<?php
global $connect;
$status_query = mysqli_query($connect, "SELECT cafe_store_status FROM cafe_status_settings LIMIT 1");
$status_data = mysqli_fetch_assoc($status_query);
$cafe_store_status = $status_data['cafe_store_status'];


$current_day = date('l');

$timetable_query = mysqli_query($connect, "SELECT open_time, close_time, is_closed FROM cafe_timetable WHERE day_name = '$current_day'");
$timetable_data = mysqli_fetch_assoc($timetable_query);


$today_open_time = $timetable_data['open_time'];
$today_close_time = $timetable_data['close_time'];
$is_closed = $timetable_data['is_closed'];

$open_days_query = mysqli_query($connect, "SELECT day_name FROM cafe_timetable WHERE is_closed = 0 ORDER BY id ASC");
$open_days_array = [];
while ($row = mysqli_fetch_assoc($open_days_query)) {
  $open_days_array[] = $row['day_name'];
}

if (count($open_days_array) == 7) {
  $opening_days_range = "Everyday";
} elseif (count($open_days_array) > 1) {
  $first_day = $open_days_array[0];
  $last_day = end($open_days_array);
  $opening_days_range = $first_day . " - " . $last_day;
} elseif (count($open_days_array) == 1) {
  $opening_days_range = $open_days_array[0];
} else {
  $opening_days_range = "Currently Closed";
}


$is_currently_open = ($cafe_store_status == 'On' && $is_closed == 0);
$status_text = $is_currently_open ? 'Open Now' : 'Closed';
$status_color = $is_currently_open ? 'text-info' : 'text-danger';
?>



<div class="banner position-relative overflow-hidden">
  <?php
  function banner_media()
  {
    global $connect;

    $sql = "SELECT banner_video FROM cafe_status_settings WHERE id = 1";
    $run = mysqli_query($connect, $sql);

    if (mysqli_num_rows($run) > 0) {
      return mysqli_fetch_assoc($run);
    }

    return false;
  }

  $media = banner_media();

  if ($media && !empty($media['banner_video'])) {

    $file = $media['banner_video'];
    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $video_extensions = ['mp4', 'webm', 'ogg'];

    if (in_array($extension, $image_extensions)) {
  ?>
      <!-- Banner Image -->
      <img src="upload/<?php echo $file; ?>"
        class="banner-video w-100 h-100 object-fit-cover"
        alt="Banner Image">

    <?php
    } elseif (in_array($extension, $video_extensions)) {
    ?>
      <!-- Banner Video -->
      <video autoplay muted loop playsinline
        class="banner-video w-100 h-100 object-fit-cover"
        id="banner-video">
        <source src="upload/<?php echo $file; ?>" type="video/mp4">
        Your browser does not support the video tag.
      </video>

  <?php
    } else {
      echo "<p>Unsupported media format.</p>";
    }
  }
  ?>

  <!-- Banner Overlay -->
  <div class="banner_overlay position-absolute top-0 start-0 w-100 h-100">
    <div class="container-fluid h-100 px-0">
      <div class="row h-100 justify-content-end align-items-center m-0">

        <!-- Right Side Content -->
        <div class="col-lg-6 pe-lg-5 pe-3 d-flex justify-content-end">
          <div class="banner_text">

            <!-- Subtitle -->
            <h3 class="banner_subtitle fs-1">
              Welcome To Our Cafe
            </h3>

            <!-- Title -->
            <h1 class="banner_title">
              Fresh Coffee <br>
              & Delicious Taste
            </h1>

            <!-- Description -->
            <p class="banner_desc">
              Enjoy premium coffee, and a peaceful
              atmosphere with your friends and family. We serve
              freshness and happiness in every cup.
            </p>

            <!-- Info Section -->
            <div class="banner_info">

              <!-- Today's Status -->
              <div class="info_box">
                <span class="info_icon">☕</span>
                <div>
                  <h5>Today</h5>

                  <p class="<?= $status_color ?> fw-bold">
                    <?= $status_text ?>
                  </p>
                </div>
              </div>

              <!-- Opening Days -->
              <div class="info_box">
                <span class="info_icon">📅</span>
                <div>
                  <h5>Opening Days</h5>

                  <p style="font-size: 13px;"><?= $opening_days_range ?></p>
                </div>
              </div>

              <!-- Opening Hours -->
              <div class="info_box">
                <span class="info_icon">🕘</span>
                <div>
                  <h5>Today's Hours</h5>
                  <p>
                    <?php if ($is_closed == 1): ?>
                      Closed Today
                    <?php else: ?>
                      <?= date('h:i A', strtotime($today_open_time)) ?> - <?= date('h:i A', strtotime($today_close_time)) ?>
                    <?php endif; ?>
                  </p>
                </div>
              </div>

            </div>

            <!-- Buttons -->
            <div class="banner_btn_group">
              <a href="menu.php">
                <button class="explore_btn">Explore Menu</button>
              </a>
              <a href="table_book.php">
                <button class="contact_btn">Book Table</button>
              </a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- =========================
     BANNER SECTION END
========================= -->
<!-- </div> -->

<!-- about us part start -->
<section class="about-section" id="about_us">
  <div class="container">

    <!-- Header Title Component -->
    <div class="text-center mb-5">
      <span class="about-tagline">OUR STORY</span>
      <h2 class="about-title">About Our Cozy Cafe</h2>
      <div class="title-divider"></div>
    </div>

    <div class="row align-items-center gy-4">

      <!-- Left Column: Content Presentation -->
      <div class="col-lg-6 order-2 order-lg-1">
        <div class="about-content-box">
          <h3 class="welcome-heading">Welcome To Our Cafe</h3>

          <p class="about-lead">
            Crafting perfect moments out of premium roasted beans, rich aromas, and a warm neighborhood atmosphere.
          </p>

          <p class="about-text">
            Every cup we pour carries a piece of our passion. We source only sustainably grown, single-origin specialty beans, roasting them carefully to unlock vibrant flavors and deep complexities.
          </p>

          <p class="about-text">
            Whether you are dropping in for your morning espresso ritual, looking for a peaceful workspace corner, or gathering with loved ones over fresh artisanal pastries, we serve happiness and freshness in every single cup.
          </p>

          <div class="mt-4 pt-2">
            <a href="about_us.php" class="btn-readmore-custom">
              <span>READ OUR STORY</span>
              <i class="fa-solid fa-arrow-right"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Right Column: Upgraded Premium Collage Presentation Wrapper -->
      <div class="col-lg-6 order-1 order-lg-2">
        <div class="about-collage-container">

          <!-- Decorative Luxury Grid Backdrop -->
          <div class="collage-grid-backdrop"></div>

          <!-- Main Big Image Frame -->
          <div class="collage-frame frame-primary">
            <!-- Replace with your actual image path: src="asset/image/about-img.png" -->
            <img src="https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?q=80&w=1000&auto=format&fit=crop" class="collage-img" alt="Our Premium Cafe Roastery">
          </div>

          <!-- Secondary Overlapping Accent Image Frame -->
          <div class="collage-frame frame-secondary d-none d-sm-block">
            <!-- Replace with your actual image path: src="asset/image/about-img.png" -->
            <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=1000&auto=format&fit=crop" class="collage-img" alt="Artisanal Espresso Crafting">
          </div>

          <!-- Decorative Badge Element -->
          <div class="collage-badge">
            <span class="badge-number">EST.</span>
            <span class="badge-text">2026</span>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>
<!-- about us part end-->
<div class="container-fluid" id="our_service">
  <section id="services">
    <div class="container">

      <div class="text-center mb-5">
        <div class="section-subtitle">Our Offerings</div>
        <h1 class="display-5 fw-bold" id="our_services_part">Our Services</h1>
        <div class="title-divider"></div>
        <p class="fs-6 mx-auto our_service_font">
          Experience perfect moments out of premium roasted beans, rich aromas, and a warm neighborhood atmosphere.
        </p>
      </div>

      <div class="row g-4">

        <div class="col-sm-12 col-md-6 col-lg-3 text-center">
          <div class="card service-card h-100">
            <div class="card-body d-flex flex-column align-items-center p-4">
              <div class="icon-box mb-4">
                <i class="fa-solid fa-heart fs-3 z-1"></i>
              </div>
              <h5 class="card-title fs-4 mb-3">Why Choose Us</h5>
              <p class="card-text fs-6 mb-4 flex-grow-1 fw-light">
                We source only sustainably grown beans, carefully unlocking vibrant flavors in every single cup we serve.
              </p>
              <a href="about_us.php" class="text-decoration-none mt-auto">
                <button class="btn btn-cafe">Learn More <i class="fa-solid fa-arrow-right"></i></button>
              </a>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-3 text-center">
          <div class="card service-card h-100">
            <div class="card-body d-flex flex-column align-items-center p-4">
              <div class="icon-box mb-4">
                <i class="fa-solid fa-mug-hot fs-3 z-1"></i>
              </div>
              <h5 class="card-title fs-4 mb-3">Quality Food</h5>
              <p class="card-text fs-6 mb-4 flex-grow-1 fw-light">
                Gather with loved ones over fresh artisanal pastries and carefully crafted dishes made with love.
              </p>
              <a href="about_us.php" class="text-decoration-none mt-auto">
                <button class="btn btn-cafe">Know More <i class="fa-solid fa-arrow-right"></i></button>
              </a>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-3 text-center">
          <div class="card service-card h-100">
            <div class="card-body d-flex flex-column align-items-center p-4">
              <div class="icon-box mb-4">
                <i class="fa-solid fa-mobile-screen fs-3 z-1"></i>
              </div>
              <h5 class="card-title fs-4 mb-3">Online Order</h5>
              <p class="card-text fs-6 mb-4 flex-grow-1 fw-light">
                Enjoy your favorite espresso ritual from the comfort of your home with our seamless online ordering system.
              </p>
              <a href="about_us.php" class="text-decoration-none mt-auto">
                <button class="btn btn-cafe">Know More <i class="fa-solid fa-arrow-right"></i></button>
              </a>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-3 text-center">
          <div class="card service-card h-100">
            <div class="card-body d-flex flex-column align-items-center p-4">
              <div class="icon-box mb-4">
                <i class="fa-solid fa-clock fs-3 z-1"></i>
              </div>
              <h5 class="card-title fs-4 mb-3">Always Open</h5>
              <p class="card-text fs-6 mb-4 flex-grow-1 fw-light">
                Whether it's an early morning start or a late-night craving, our doors are always open to serve you.
              </p>
              <a href="about_us.php" class="text-decoration-none mt-auto">
                <button class="btn btn-cafe">Know More <i class="fa-solid fa-arrow-right"></i></button>
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>
<!-- order section start -->
<section class="order_section pb-5">
  <div class="container-fluid">
    <div class="special-menu-hdr-container text-center pt-5" id="services">
      <span class="special-menu-hdr-sub">OUR MENU OFFERINGS</span>
      <h1 class="special-menu-hdr-main display-5 fw-bold">Our Cafe Menu</h1>
      <div class="special-menu-hdr-line"></div>
      <p class="special-menu-hdr-text">Experience perfect moments out of premium roasted beans, and a warm neighborhood atmosphere.</p>
    </div>
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
        $category_map = [];
        $allcats = AllDetails('categories');
        if ($allcats) {
          foreach ($allcats as $cat) {
            $category_map[$cat['id']] = strtolower(str_replace(' ', '-', $cat['name']));
          }
        }

        if (isset($_SESSION['id'])) {

          $Allcafeitems = Allproducts('products');
          if ($Allcafeitems) {
            $idx = 0;
            foreach ($Allcafeitems as $item) {
              $cat_slug = $category_map[$item['category_id']] ?? strtolower(str_replace(' ', '-', $item['category_id']));
              $init_style = ($idx >= 8) ? 'style="display: none;"' : '';
              $idx++;
        ?>

            <div class="col-xl-3 col-lg-4 col-md-6 menu-item <?php echo $cat_slug; ?>" <?php echo $init_style; ?>>
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
          }
        } else {

          $Allcafeitems = Allproducts('products');
          if ($Allcafeitems) {
            $idx = 0;
            foreach ($Allcafeitems as $item) {
              $cat_slug = $category_map[$item['category_id']] ?? strtolower(str_replace(' ', '-', $item['category_id']));
              $init_style = ($idx >= 8) ? 'style="display: none;"' : '';
              $idx++;
        ?>

            <div class="col-xl-3 col-lg-4 col-md-6 menu-item <?php echo $cat_slug; ?>" <?php echo $init_style; ?>>
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
        }
        ?>

      </div>

      <div id="noItemsMessage" class="no-items-message" style="display: none;">
        <i class="fa-solid fa-mug-hot" style="font-size: 3rem; color: var(--cafe-primary); margin-bottom: 15px; opacity: 0.5;"></i>
        <h4 class="font-serif">No Items Found</h4>
        <p class="font-sans text-muted">We are currently crafting new beverages for this category.</p>
      </div>

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
   <div class="d-flex justify-content-center align-items-center my-5">
    <a href="menu.php" class="cafe-outline-btn">
        View More Items <i class="fa-solid fa-arrow-right ms-2"></i>
    </a>
</div>
</section>
<!-- order section end -->
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/PHPMailer/src/Exception.php';
require_once 'vendor/PHPMailer/src/PHPMailer.php';
require_once 'vendor/PHPMailer/src/SMTP.php';

// -------------------------------------------------------------
// 1. Fetch Weekly Schedule from cafe_timetable
// -------------------------------------------------------------
$weekly_schedule = [];
global $connect;

$sql_schedule = "SELECT day_name, open_time, close_time, is_closed FROM cafe_timetable";
$run_schedule = mysqli_query($connect, $sql_schedule);

if ($run_schedule) {
  while ($row = mysqli_fetch_assoc($run_schedule)) {
    // Storing data with lowercase day names for easy matching in JavaScript
    $weekly_schedule[strtolower($row['day_name'])] = [
      'open_time' => $row['open_time'],
      'close_time' => $row['close_time'],
      'is_closed' => $row['is_closed']
    ];
  }
}

// Convert the schedule array to JSON for JavaScript
$schedule_json = json_encode($weekly_schedule);

// Current date to block past dates in the HTML calendar
$today_date = date('Y-m-d');

// -------------------------------------------------------------
// 2. Table Booking Mail Function
// -------------------------------------------------------------
if (!function_exists('tableBookingMail')) {
  function tableBookingMail($customerName, $customerEmail, $bookingDate, $bookingTime, $guests, $decoration, $totalAmount, $paymentId)
  {
    $mail = new PHPMailer(true);

    try {
      $mail->isSMTP();
      $mail->Host       = 'smtp.gmail.com';
      $mail->SMTPAuth   = true;
      $mail->Username   = 'santusau2006@gmail.com';
      $mail->Password   = 'lohn qfyw axmi cqti';
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port       = 587;

      $mail->SMTPOptions = [
        'ssl' => [
          'verify_peer'       => false,
          'verify_peer_name'  => false,
          'allow_self_signed' => true
        ]
      ];

      $mail->setFrom('santusau2006@gmail.com', 'Cafe Website');
      $mail->addAddress($customerEmail);
      $mail->isHTML(true);
      $mail->Subject = "Table Booking Confirmed - Cafe Website";

      $mail->Body = "
            <div style='font-family:Arial;padding:20px; border:1px solid #ddd; border-radius:10px;'>
                <h2 style='color: #BD7753;'>Thank You For Your Booking ☕</h2>
                <p>Hello <b>{$customerName}</b>,</p>
                <p>Your table booking and payment have been successfully received. Here are your details:</p>
                
                <hr style='border:1px solid #eee;'>
                
                <p><b>Date :</b> {$bookingDate}</p>
                <p><b>Time :</b> {$bookingTime}</p>
                <p><b>Guests :</b> {$guests} Person(s)</p>
                <p><b>Decoration :</b> {$decoration}</p>
                <p><b>Total Amount Paid :</b> ₹{$totalAmount}</p>
                <p><b>Payment ID :</b> {$paymentId}</p>
                <p><b>Booking Status :</b> <span style='color: #dbb809;'>Pending</span></p>
                
                <hr style='border:1px solid #eee;'>
                
                <p>We look forward to serving you.</p>
                <br>
                <h3>Thank you for choosing Delicious Cafe ☕</h3>
            </div>
            ";

      return $mail->send();
    } catch (Exception $e) {
      return false;
    }
  }
}

// -------------------------------------------------------------
// 3. Cafe Settings Fetch
// -------------------------------------------------------------
function accesscafesattings()
{
  global $connect;
  $sql = "SELECT * FROM cafe_status_settings WHERE id=1";
  $run = mysqli_query($connect, $sql);
  if (mysqli_num_rows($run) > 0) {
    return mysqli_fetch_assoc($run);
  } else {
    return false;
  }
}
$cafesattings = accesscafesattings();

// -------------------------------------------------------------
// 4. Form Submission Logic
// -------------------------------------------------------------
if (isset($_POST['book_table'])) {
  if (empty($_SESSION['id'])) {
    showCafeAlert('Sign In Required', 'Please sign in first to book a table.', 'warning', 'Login_form.php');
  }
  global $connect;

  $customerid = $_SESSION['id'];
  $full_name = mysqli_real_escape_string($connect, $_POST['full_name']);
  $email = mysqli_real_escape_string($connect, $_POST['email']);
  $booking_date = mysqli_real_escape_string($connect, $_POST['booking_date']);
  $booking_time = mysqli_real_escape_string($connect, $_POST['booking_time']);
  $guests = intval($_POST['guests']);
  $decoration_option = mysqli_real_escape_string($connect, $_POST['decoration_option']);
  $special_requests = mysqli_real_escape_string($connect, $_POST['special_requests']);
  $payment_id = mysqli_real_escape_string($connect, $_POST['razorpay_payment_id']);

  $base_amount = ($decoration_option == 'none') ? $cafesattings['no_decoration_fees'] : $cafesattings['decoration_fees'];
  $discount_percentage = $cafesattings['offer'];
  $discount_amount = ($base_amount * $discount_percentage) / 100;
  $final_booking_amount = $base_amount - $discount_amount;

  $booking_status = 'pending';
  $payment_status = 'Paid';

  $insert_query = "INSERT INTO tablebook 
                    (customer_id, full_name, email, booking_date, booking_time, guests, decoration_option, booking_amount, special_requests, booking_status, payment_status, payment_id) 
                    VALUES 
                    ('$customerid','$full_name', '$email', '$booking_date', '$booking_time', '$guests', '$decoration_option', '$final_booking_amount', '$special_requests', '$booking_status', '$payment_status', '$payment_id')";

  if (mysqli_query($connect, $insert_query)) {
    $mailSent = tableBookingMail($full_name, $email, $booking_date, $booking_time, $guests, $decoration_option, $final_booking_amount, $payment_id);
    if ($mailSent) {
      showCafeAlert('Booking Confirmed!', 'Payment Successful! Table booked. A confirmation email has been sent.', 'success', 'index.php');
    } else {
      showCafeAlert('Booking Successful!', 'Payment Successful! Table booked. (Email confirmation could not be sent).', 'success', 'index.php');
    }
  } else {
    showCafeAlert('Booking Error', 'Something went wrong saving your booking. Please contact support.', 'error', 'index.php');
  }
}
?>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<div class="special-menu-hdr-container text-center pt-3 pb-4" id="services">
  <span class="special-menu-hdr-sub text-uppercase fw-bold" style="color: #BD7753; letter-spacing: 2px;">BOOK YOUR TABLE</span>
  <h1 class="special-menu-hdr-main display-5 fw-bold mt-2 fs-1" style="color: #36241C;">Online Reservation</h1>
  <div class="special-menu-hdr-line" style="width: 60px; height: 3px; background-color: #BD7753; margin: 15px auto;"></div>
  <p class="special-menu-hdr-text mx-auto px-3 pb-3" style="max-width: 100%; color: #6B615B;">Experience perfect moments out of premium roasted beans, rich aromas, and a warm neighborhood atmosphere.</p>
</div>

<section class="reservation-section" style="background-color: #fafaf2;">
  <div class="container">
    <div class="row g-0 align-items-stretch cafe-reservation-wrapper shadow-sm overflow-hidden" style="border-radius: 16px;">

      <div class="col-lg-5 cafe-promo-box p-4 p-lg-5 d-flex flex-column justify-content-center">
        <!-- Sidebar Info -->
        <div class="mb-4">
          <span class="text-uppercase fw-bold" style="color: #BD7753; letter-spacing: 2px; font-size: 0.95rem;">Exclusive Service</span>
          <h2 class="display-6 cafe-serif mt-2 mb-3" style="color: #36241C;">Reserve & Celebrate</h2>
          <p style="color: #6B615B; font-size: 1.05rem; line-height: 1.6;">Secure your table online and let us know how we can tailor your ambiance for a truly perfect visit.</p>
          <h4 style="color: #e28e07"><span class="fs-2 me-2"><?php echo $cafesattings['offer']; ?>%</span>Off For Online Booking.</h4>
        </div>

        <div class="pricing-info-box mb-4 p-4 rounded-3 shadow-sm" style="background-color: #ffffff; border-left: 4px solid #BD7753;">
          <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
            <span class="fw-bold" style="color: #36241C; font-size: 1.05rem;">Standard Table Booking</span>
            <span class="fw-bold fs-5" style="color: #BD7753;">₹<?php echo $cafesattings['no_decoration_fees']; ?></span>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex flex-column">
              <span class="fw-bold" style="color: #36241C; font-size: 1.05rem;">Occasion Decoration</span>
              <small style="color: #6B615B;">(Birthdays, etc.)</small>
            </div>
            <span class="fw-bold fs-5" style="color: #BD7753;">₹<?php echo $cafesattings['decoration_fees']; ?></span>
          </div>
        </div>
      </div>

      <div class="col-lg-7 cafe-form-box p-4 p-lg-5" style="background-color: #ffffff;">
        <h3 class="text-uppercase fw-bold text-center" style="font-family: 'Lato', sans-serif; color: #872e02; font-size: 1.5rem; letter-spacing: 4px;">BOOK YOUR TABLE</h3>
        <div class="special-menu-hdr-line mb-3" style="width: 60px; height: 3px; background-color: #BD7753; margin: 15px auto;"></div>

        <?php
        $logged_user_name = '';
        $logged_user_email = '';
        if (isset($_SESSION['id'])) {
          $logged_user = userdetails($_SESSION['id']);
          if ($logged_user) {
            $logged_user_name = $logged_user['name'] ?? '';
            $logged_user_email = $logged_user['email_id'] ?? '';
          }
        }
        ?>
        <form method="POST" action="" id="cafeReservationForm" class="needs-validation" novalidate>
          <input type="hidden" name="book_table" value="1">
          <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="cafe-input-label">Full Name <span class="text-danger">*</span></label>
              <input type="text" name="full_name" id="resName" class="form-control cafe-modern-input" value="<?php echo htmlspecialchars($logged_user_name); ?>" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="cafe-input-label">Email Address <span class="text-danger">*</span></label>
              <input type="email" name="email" id="resEmail" class="form-control cafe-modern-input" value="<?php echo htmlspecialchars($logged_user_email); ?>" required>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="cafe-input-label">Date <span class="text-danger">*</span></label>
              <input type="date" name="booking_date" id="resDate" class="form-control cafe-modern-input" min="<?php echo $today_date; ?>" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="cafe-input-label">Time <span class="text-danger">*</span></label>
              <input type="time" name="booking_time" id="resTime" class="form-control cafe-modern-input" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="cafe-input-label">Guests <span class="text-danger">*</span></label>
              <select name="guests" id="resPerson" class="form-select cafe-modern-input" required>
                <option value="" disabled selected hidden>Choose...</option>
                <option value="1">1 Person</option>
                <option value="2">2 People</option>
                <option value="3">3 People</option>
                <option value="4">4 People</option>
                <option value="5">5+ People</option>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label class="cafe-input-label">Occasion Decoration</label>
            <select name="decoration_option" id="resOccasion" class="form-select cafe-modern-input">
              <option value="none">No Decoration (Standard Booking - ₹<?php echo $cafesattings['no_decoration_fees']; ?>)</option>
              <option value="Anniversary">Anniversary Setup (+₹<?php echo $cafesattings['decoration_fees']; ?>)</option>
              <option value="Birthday">Birthday Setup (+₹<?php echo $cafesattings['decoration_fees']; ?>)</option>
              <option value="Special Party">Special Party Setup (+₹<?php echo $cafesattings['decoration_fees']; ?>)</option>
            </select>
          </div>

          <div class="mb-4">
            <label class="cafe-input-label">Special Requests (Optional)</label>
            <textarea name="special_requests" id="resCustomization" class="form-control cafe-modern-input" rows="2"></textarea>
          </div>

          <button type="button" onclick="<?php echo isset($_SESSION['id']) ? 'payWithRazorpay()' : "showGuestAlert('Reserve a Table')"; ?>" class="btn cafe-btn-dark w-100 py-3 text-uppercase fw-bold mt-2">
            Pay & Book Table
          </button>
        </form>
      </div>

    </div>
  </div>
</section>








<!-- Testimonial part -->
<div class="testimonial-section">
  <div class="container">

    <!-- Header Part -->
    <div class="text-center">
      <h3 class="cafe-subtitle">Testimonial</h3>
      <h2 class="cafe-title display-6">What Our Clients Say</h2>
      <div class="heading-line"></div>
    </div>

    <!-- Scrollable Cards Container -->
    <div class="testimonial-scroll-container">
      <?php
      $allfeedback = Allfeedback();
      foreach ($allfeedback as $feedback) {
        $userdetail = userdetails($feedback['customers_id']);
      ?>
        <div class="testimonial-card">
          <div class="card-inner">
            <!-- Background Quote Icon (Requires FontAwesome) -->
            <i class="fa-solid fa-quote-right quote-icon"></i>

            <!-- Review Text -->
            <p class="review-text ">"<?php echo htmlspecialchars($feedback['review']); ?>"</p>

            <!-- Client Details & Stars -->
            <div class="client-info">
              <img class="client-img" src="upload/<?php echo htmlspecialchars($userdetail['profile']); ?>" alt="<?php echo htmlspecialchars($userdetail['name']); ?>">
              <div class="client-details">
                <h3 class="client-name"><?php echo htmlspecialchars($userdetail['name']); ?></h3>
                <div class="stars">
                  <?php
                  for ($i = 1; $i <= $feedback['rating']; $i++) {
                    echo "★";
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php
      }
      ?>
    </div>

  </div>
</div>
<!--end of Testimonial part -->
<section class="contact-section ">

  <div class="container">

    <!-- TITLE -->

    <div class="cafe-section-title">
      <span class="cafe-subtitle">GET IN TOUCH</span>
      <h1 class="cafe-heading">Contact & Feedback</h1>
      <div class="cafe-divider"></div>
      <!-- <p class="cafe-desc">We would love to hear about your experience, rich aromas, and our warm neighborhood atmosphere.</p> -->
    </div>

    <div class="row g-4">

      <!-- CONTACT -->

      <div class="col-lg-5">

        <div class="contact-card">

          <div class="contact-item">

            <div class="contact-icon">
              <i class="bi bi-geo-alt-fill"></i>
            </div>

            <div>
              <h5>Address</h5>
              <p>CCLMS, Contai, India</p>
            </div>

          </div>

          <div class="contact-item">

            <div class="contact-icon">
              <i class="bi bi-telephone-fill"></i>
            </div>

            <div>
              <h5>Call Us</h5>
              <p>+91 2583691235</p>
            </div>

          </div>
          <div class="contact-item">

            <div class="contact-icon">
              <i class="fa-brands fa-whatsapp fs-3 "></i>
            </div>

            <div>
              <h5>Whatsapp</h5>
              <p>+91 2583691235</p>
            </div>

          </div>

          <div class="contact-item">

            <div class="contact-icon">
              <i class="bi bi-envelope-fill"></i>
            </div>

            <div>
              <h5>Email Us</h5>
              <p>santusau@gmail.com</p>
            </div>

          </div>

          <!-- MAP -->

          <div class="map-box mt-3">

            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3704.885632941286!2d87.73476217505369!3d21.784686880060512!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a0326f87e6e8479%3A0xb610eefe9d9387c1!2sContai%20College%20of%20Learning%20%26%20Management%20Science!5e0!3m2!1sen!2sin!4v1766326887680!5m2!1sen!2sin"
              allowfullscreen=""
              loading="lazy">
            </iframe>

          </div>

        </div>

      </div>

      <!-- FEEDBACK -->

      <?php
      if (isset($_SESSION['username'])) {

        $review = single_feedback('feedback', $_SESSION['id']);
        $rating = $review['rating'] ?? 0;
      ?>

        <div class="col-lg-7">

          <div class="feedback-box">

            <h2 style="font-family:'Playfair Display', serif;">
              <i class="fa-solid fa-star"></i>
              Rate Our Service
            </h2>

            <!-- FORM -->
            <form action="Ui-All-Function.php" method="POST">

              <!-- STARS -->
              <div class="rating">

                <input
                  type="radio"
                  name="star"
                  id="star5"
                  value="5"
                  <?= ($rating == 5) ? 'checked' : '' ?>>
                <label for="star5">★</label>


                <input
                  type="radio"
                  name="star"
                  id="star4"
                  value="4"
                  <?= ($rating == 4) ? 'checked' : '' ?>>
                <label for="star4">★</label>


                <input
                  type="radio"
                  name="star"
                  id="star3"
                  value="3"
                  <?= ($rating == 3) ? 'checked' : '' ?>>
                <label for="star3">★</label>


                <input
                  type="radio"
                  name="star"
                  id="star2"
                  value="2"
                  <?= ($rating == 2) ? 'checked' : '' ?>>
                <label for="star2">★</label>


                <input
                  type="radio"
                  name="star"
                  id="star1"
                  value="1"
                  <?= ($rating == 1) ? 'checked' : '' ?>>
                <label for="star1">★</label>

              </div>


              <!-- RATING TEXT -->
              <div class="rating-text" id="ratingText">
                <?php
                if ($rating == 1) {
                  echo "😞 Poor";
                } else if ($rating == 2) {
                  echo "😐 Average";
                } else if ($rating == 3) {
                  echo "🙂 Good";
                } else if ($rating == 4) {
                  echo "😊 Very Good";
                } else if ($rating == 5) {
                  echo "😍 Excellent";
                } else {
                  echo "<h5 style='font-family:Playfair Display', serif;'>Give The Rating</h5>";
                }
                ?>
              </div>


              <!-- REVIEW -->
              <textarea
                class="fs-5"
                name="review"
                rows="10"
                cols="50" style="background-color: #FAF8F5;"><?php echo $review['review'] ?? ''; ?></textarea>


              <!-- BUTTON -->
              <?php if (!empty($review)) { ?>

                <button type="submit" name="feedback_edit_btn">
                  Edit Review
                </button>

              <?php } else { ?>

                <button type="submit" name="feedback-btn">
                  Submit Review
                </button>

              <?php } ?>

            </form>

          </div>

        </div>

      <?php } else {
      ?>
        <div class="col-lg-7">

          <div class="feedback-box">

            <h2 style="font-family:'Playfair Display', serif;">
              <i class="fa-solid fa-star"></i>
              Rate Our Service
            </h2>

            <!-- STARS -->
            <form action="Ui-All-Function.php" method="POST" enctype="multipart/form-data" onsubmit="showGuestAlert('Submit Review'); return false;">
              <div class="rating">

                <input type="radio" name="star" id="star5" value="5">
                <label for="star5">★</label>

                <input type="radio" name="star" id="star4" value="4">
                <label for="star4">★</label>

                <input type="radio" name="star" id="star3" value="3">
                <label for="star3">★</label>

                <input type="radio" name="star" id="star2" value="2">
                <label for="star2">★</label>

                <input type="radio" name="star" id="star1" value="1">
                <label for="star1">★</label>

              </div>

              <!-- DYNAMIC TEXT -->

              <div class="rating-text" id="ratingText" style="font-family:'Playfair Display', serif;">
                Select Rating
              </div>

              <!-- REVIEW -->

              <textarea name="review" rows="10" cols="50" placeholder="Write your review..."></textarea>

              <!-- BUTTON -->

              <button type="submit" name="feedback-btn">
                Submit Review
              </button>


            </form>

          </div>

        </div>
      <?php
      }
      ?>
    </div>

  </div>

</section>


<style>
  .fade-in {
    opacity: 0;
    animation: smoothReveal 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  }

  @keyframes smoothReveal {
    0% {
      opacity: 0;
      transform: translateY(20px) scale(0.97);
    }
    100% {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
  }
</style>

<script>
  // ================================================================
  // Category Filter Functionality
  // ================================================================
  document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const allItems = Array.from(document.querySelectorAll('#menuGrid .menu-item'));
    const noItemsMsg = document.getElementById('noItemsMessage');
    const carousel = document.getElementById('menuGrid');

    if (!filterBtns.length || !allItems.length) return;

    function applyFilter(filter) {
      let visibleCount = 0;

      allItems.forEach(function (item) {
        item.classList.remove('fade-in');
        
        let shouldShow = false;
        if (filter === 'all') {
          // When "All Items" is selected on the home page, only show the first 8 products
          if (visibleCount < 8) {
            shouldShow = true;
          }
        } else {
          // When a specific category is selected, show ALL products of that category
          if (item.classList.contains(filter)) {
            shouldShow = true;
          }
        }

        if (shouldShow) {
          item.style.display = '';
          void item.offsetWidth;
          item.classList.add('fade-in');
          visibleCount++;
        } else {
          item.style.display = 'none';
        }
      });

      if (noItemsMsg) {
        noItemsMsg.style.display = (visibleCount === 0) ? 'block' : 'none';
      }

      if (carousel) {
        carousel.scrollLeft = 0;
      }

      // Sync mobile carousel dots if function exists
      if (typeof window.initCarouselPagination === 'function') {
        window.initCarouselPagination();
      }
    }

    // Set initial filter to 'all' on page load (showing only 8 items)
    applyFilter('all');

    filterBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        filterBtns.forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const filter = this.dataset.filter;
        applyFilter(filter);
      });
    });
  });

  // Load Variables
  const noDecoFee = <?php echo floatval($cafesattings['no_decoration_fees']); ?>;
  const decoFee = <?php echo floatval($cafesattings['decoration_fees']); ?>;
  const discountPercentage = <?php echo floatval($cafesattings['offer']); ?>;

  // Load Timetable Data from PHP
  const weeklySchedule = <?php echo $schedule_json ?? '{}'; ?>;

  // Calculate Amount
  function calculateTotalAmount() {
    let occasion = document.getElementById('resOccasion').value;
    let baseAmount = (occasion === 'none') ? noDecoFee : decoFee;
    let discountAmount = (baseAmount * discountPercentage) / 100;
    return baseAmount - discountAmount;
  }

  // -------------------------------------------------------------
  // Date & Time Validation Logic
  // -------------------------------------------------------------
  document.getElementById('resDate').addEventListener('change', function() {
    let selectedDate = this.value;
    if (!selectedDate) return;

    // 1. Find the Day Name of the selected date
    let dateObj = new Date(selectedDate);
    let daysOfWeek = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    let dayName = daysOfWeek[dateObj.getDay()];

    // 2. Get the schedule for that specific day
    let daySchedule = weeklySchedule[dayName];

    // 3. Check if the cafe is closed on this day (is_closed == 1)
    if (daySchedule && daySchedule.is_closed == 1) {
      // Capitalize first letter of day name for alert
      let displayDay = dayName.charAt(0).toUpperCase() + dayName.slice(1);
      cafeAlert('Cafe Closed', `Sorry, the cafe is closed on ${displayDay}s. Please select another date.`, 'warning');

      // Reset Inputs
      this.value = '';
      document.getElementById('resTime').value = '';
      return;
    }

    // Check time if date is valid
    validateTime();
  });

  document.getElementById('resTime').addEventListener('change', function() {
    validateTime();
  });

  function validateTime() {
    let dateInput = document.getElementById('resDate').value;
    let timeInput = document.getElementById('resTime');

    if (!dateInput || !timeInput.value) return;

    let dateObj = new Date(dateInput);
    let daysOfWeek = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    let dayName = daysOfWeek[dateObj.getDay()];
    let daySchedule = weeklySchedule[dayName];

    // Format selected time to match DB format "HH:MM:SS" for proper comparison
    let selectedTime = timeInput.value + ':00';

    // A. Verify if selected time is within Cafe Open & Close Hours
    if (daySchedule) {
      if (selectedTime < daySchedule.open_time || selectedTime > daySchedule.close_time) {
        // Remove seconds for a cleaner alert message (e.g. 10:00)
        let openTimeFormat = daySchedule.open_time.substring(0, 5);
        let closeTimeFormat = daySchedule.close_time.substring(0, 5);

        cafeAlert('Outside Operating Hours', `For ${dayName.charAt(0).toUpperCase() + dayName.slice(1)}, please select a time between ${openTimeFormat} and ${closeTimeFormat}.`, 'warning');
        timeInput.value = '';
        return;
      }
    }

    // B. Verify if the time has already passed for today
    let today = new Date();
    let dd = String(today.getDate()).padStart(2, '0');
    let mm = String(today.getMonth() + 1).padStart(2, '0');
    let yyyy = today.getFullYear();
    let todayStr = yyyy + '-' + mm + '-' + dd;

    if (dateInput === todayStr) {
      let currentHours = String(today.getHours()).padStart(2, '0');
      let currentMinutes = String(today.getMinutes()).padStart(2, '0');
      let currentTime = currentHours + ':' + currentMinutes + ':00';

      if (selectedTime < currentTime) {
        cafeAlert('Invalid Time', "Please select a valid future time for today's booking.", 'warning');
        timeInput.value = '';
      }
    }
  }

  // -------------------------------------------------------------
  // Razorpay Payment Handler
  // -------------------------------------------------------------
  const isUserLoggedIn = <?php echo isset($_SESSION['id']) ? 'true' : 'false'; ?>;

  function payWithRazorpay() {
    if (!isUserLoggedIn) {
      showGuestAlert('Reserve a Table');
      return;
    }

    let form = document.getElementById('cafeReservationForm');

    // Check mandatory fields validation
    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }

    let selectedDate = document.getElementById('resDate').value;
    let selectedTime = document.getElementById('resTime').value;

    if (!selectedDate || !selectedTime) {
      cafeAlert('Date & Time Required', 'Please select a valid reservation date and time before proceeding.', 'warning');
      return;
    }

    let name = document.getElementById('resName').value;
    let email = document.getElementById('resEmail').value;
    let amount = calculateTotalAmount();

    var options = {
      "key": "rzp_test_TGe16Sk8SxvzUx",
      "amount": amount * 100,
      "currency": "INR",
      "name": "Delicious Cafe",
      "description": "Table Reservation Payment",
      "handler": function(response) {
        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
        form.submit();
      },
      "prefill": {
        "name": name,
        "email": email
      },
      "theme": {
       color: "#e79006"
      }
    };

    var rzp1 = new Razorpay(options);
    rzp1.on('payment.failed', function(response) {
      cafeAlert('Payment Failed', "Reason: " + response.error.description, 'error');
    });
    rzp1.open();
  }
</script>


<?php
include 'footer.php';
?>