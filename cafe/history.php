<?php
include_once('header.php');
include_once('Ui-All-Function.php');

// =========================================================================
// BOOKING & ORDER CANCELLATION & EMAIL LOGIC
// =========================================================================
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/PHPMailer/src/Exception.php';
require_once 'vendor/PHPMailer/src/PHPMailer.php';
require_once 'vendor/PHPMailer/src/SMTP.php';

// ১. Cancellation Mail Function
if (!function_exists('cancelBookingMail')) {
    function cancelBookingMail($customerName, $customerEmail, $bookingDate) {
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
                'ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]
            ];

            $mail->setFrom('santusau2006@gmail.com', 'Delicious Cafe');
            $mail->addAddress($customerEmail);
            $mail->isHTML(true);
            $mail->Subject = "Table Booking Cancelled";

            $mail->Body = "
            <div style='font-family:Arial;padding:20px; border:1px solid #ddd; border-radius:10px;'>
                <h2 style='color: #d9534f;'>Booking Cancelled 🚫</h2>
                <p>Hello <b>{$customerName}</b>,</p>
                <p>Your table booking for <b>{$bookingDate}</b> has been successfully cancelled as per your request.</p>
                <hr style='border:1px solid #eee;'>
                <p>We hope to serve you again in the future.</p>
                <h3>Thank you, Delicious Cafe</h3>
            </div>";

            return $mail->send();
        } catch (Exception $e) {
            return false;
        }
    }
}

// ২. Booking Cancel Processing (Only if Pending)
if (isset($_GET['cancel_booking_id'])) {
    global $connect;
    $cancel_id = mysqli_real_escape_string($connect, $_GET['cancel_booking_id']);
    
    // User Session ID
    $customer_id = $_SESSION['id']; 

    $fetch_query = "SELECT * FROM tablebook WHERE id='$cancel_id' AND customer_id='$customer_id' AND booking_status = 'Pending'";
    $run_fetch = mysqli_query($connect, $fetch_query);

    if (mysqli_num_rows($run_fetch) > 0) {
        $row = mysqli_fetch_assoc($run_fetch);
        
        $update_query = "UPDATE tablebook SET booking_status='Cancelled by Customer' WHERE id='$cancel_id'";
        if (mysqli_query($connect, $update_query)) {
           
            cancelBookingMail($row['full_name'], $row['email'], date('d M, Y', strtotime($row['booking_date'])));
            
            showCafeAlert('Booking Cancelled', 'Your table reservation has been cancelled successfully.', 'success', $_SERVER['PHP_SELF']);
        }
    } else {
        showCafeAlert('Cancellation Failed', 'Your booking is already confirmed or has already been cancelled.', 'warning', $_SERVER['PHP_SELF']);
    }
}

// ৩. Order Cancel Processing (Only if Pending)
if (isset($_GET['cancel_order_id'])) {
    global $connect;
    $cancel_order_id = mysqli_real_escape_string($connect, $_GET['cancel_order_id']);
    
    // User Session ID
    $customer_id = $_SESSION['id']; 

    // Fetch to make sure the order belongs to this customer and is still pending
    $fetch_order_query = "SELECT * FROM orders WHERE id='$cancel_order_id' AND customer_id='$customer_id' AND order_status = 'Pending'";
    $run_order_fetch = mysqli_query($connect, $fetch_order_query);

    if (mysqli_num_rows($run_order_fetch) > 0) {
        // Update order status to 'Cancelled'
        $update_order_query = "UPDATE orders SET order_status='Cancelled' WHERE id='$cancel_order_id'";
        if (mysqli_query($connect, $update_order_query)) {
            showCafeAlert('Order Cancelled', 'Your order has been cancelled successfully.', 'success', $_SERVER['PHP_SELF']);
        }
    } else {
        showCafeAlert('Cancellation Failed', 'Your order might already be processed or cancelled.', 'warning', $_SERVER['PHP_SELF']);
    }
}
// =========================================================================
?>

<style>
    /* IMPORT FONTS: Inter (Modern UI) & Playfair Display (Elegant Serif for Banner) */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap');

    :root {
        --primary: #8b5a2b;
        --primary-light: #fdf8f5;
        --bg-color: #f9fafb;
        --card-bg: #ffffff;
        --text-main: #111827;
        --text-muted: #6b7280;
        --border-color: #e5e7eb;
        --radius: 12px;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --transition: all 0.2s ease-in-out;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--bg-color);
        color: var(--text-main);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        -webkit-font-smoothing: antialiased;
        background-color: #faf7f2;
    }

    /* --- CUSTOM HERO BANNER STYLES --- */
    .custom-img-hero-section {
        position: relative;
        width: 100%;
        height: 200px;
        background-image: url('https://images.unsplash.com/photo-1497935586351-b67a49e012bf?q=80&w=1600&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .custom-hero-overlay {
        position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(40, 25, 15, 0.65); z-index: 1;
    }

    .custom-hero-content { position: relative; z-index: 2; color: #ffffff; padding: 0 20px; margin-top: -40px; }

    .custom-hero-title {
        font-family: 'Playfair Display', serif; font-size: 3.5rem; font-weight: 700; margin: 0 0 12px 0; letter-spacing: -0.5px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .custom-hero-subtitle { font-size: 1.1rem; font-weight: 400; margin: 0; color: rgba(255, 255, 255, 0.95); }

    .custom-hero-gold-bar {
        position: absolute; bottom: 0; left: 0; width: 100%; height: 6px; background-color: #b89247; z-index: 2;
    }

    /* --- DASHBOARD CONTAINER --- */
    .container-wrapper { max-width: 1100px; margin: 0 auto; padding: 60px 20px 40px; width: 100%; flex: 1; }

    /* --- STATS SECTION --- */
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 40px; }
    .stat-card { background: var(--card-bg); padding: 24px; border-radius: var(--radius); border: 1px solid var(--border-color); box-shadow: var(--shadow-sm); display: flex; align-items: center; gap: 16px; transition: var(--transition); }
    .stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
    .stat-icon { width: 48px; height: 48px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
    .stat-details { display: flex; flex-direction: column; }
    .stat-value { font-size: 1.5rem; font-weight: 700; line-height: 1.2; }
    .stat-label { font-size: 0.875rem; color: var(--text-muted); font-weight: 500; }

    /* --- SECTION HEADERS & FILTERS --- */
    .section-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--border-color); flex-wrap: wrap; gap: 16px; }
    .section-title { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 600; display: flex; align-items: center; gap: 8px; color: #2c1e15; margin: 0; }
    .section-title i { color: var(--primary); }
    .filter-group-wrapper { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
    .filter-select { padding: 8px 32px 8px 12px; border: 1px solid var(--border-color); border-radius: 8px; background-color: var(--card-bg); color: var(--text-main); font-size: 0.875rem; font-family: inherit; cursor: pointer; appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 8px center; transition: var(--transition); }
    input.filter-select { background-image: none; padding-right: 12px; }
    .filter-select:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(139, 90, 43, 0.1); }
    .reset-btn { background: transparent; border: none; color: var(--text-muted); font-size: 0.875rem; cursor: pointer; font-weight: 500; display: flex; align-items: center; gap: 4px; padding: 8px; border-radius: 6px; transition: var(--transition); }
    .reset-btn:hover { background: var(--border-color); color: var(--text-main); }

    /* --- CARDS LIST --- */
    .list-container { display: flex; flex-direction: column; gap: 16px; margin-bottom: 40px; }
    .data-card { background: var(--card-bg); border-radius: var(--radius); border: 1px solid var(--border-color); box-shadow: var(--shadow-sm); padding: 24px; display: flex; flex-direction: column; transition: var(--transition); }
    .data-card:hover { border-color: #d1d5db; box-shadow: var(--shadow-md); }
    .card-header { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 12px; }
    .card-id-block { display: flex; flex-direction: column; gap: 4px; }
    .card-id { font-weight: 600; font-size: 1.125rem; }
    .card-date { font-size: 0.875rem; color: var(--text-muted); }
    .card-badges { display: flex; gap: 10px; }
    
    .badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .badge-paid { background: #e0f2fe; color: #0369a1; }
    .badge-cod { background: #cd9fee; color: #020202; }
    .badge-pending { background: #fef08a; color: #854d0e; }
    .badge-processing { background: #ffedd5; color: #9a3412; }
    .badge-completed { background: #dcfce7; color: #166534; }
    .badge-cancel { background-color: #fee2e2; color: #dc2626; }
    .badge-confirmed { background-color: #e0f2fe; color: #0369a1; }

    .card-body { display: flex; gap: 16px; background: var(--bg-color); padding: 16px; border-radius: 8px; }
    .item-image { width: 60px; height: 60px; border-radius: 8px; overflow: hidden; background: #eaeaea; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--text-muted); }
    .item-image img { width: 100%; height: 100%; object-fit: cover; }
    .item-details { flex: 1; display: flex; flex-direction: column; justify-content: center; }
    .item-name { font-weight: 600; font-size: 1.2rem; margin-bottom: 2px; }
    .item-meta { font-size: 0.90rem; color: #462b01; margin-bottom: 6px; }
    .item-qty { font-size: 0.75rem; font-weight: 600; background: var(--border-color); padding: 2px 8px; border-radius: 4px; width: fit-content; }
    
    .card-footer { display: flex; justify-content: space-between; align-items: center; padding-top: 16px; border-top: 1px dashed var(--border-color); flex-wrap: wrap; gap: 16px; }
    .footer-stat { display: flex; flex-direction: column; }
    .footer-stat-label { font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; }
    .footer-stat-value { font-size: 1rem; font-weight: 600; color: var(--text-main); }
    
    .footer-action-group { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
    .btn-cancel-item { background-color: #ffffff; color: #ef4444; border: 1px solid #fca5a5; padding: 6px 14px; border-radius: 6px; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: var(--transition); display: inline-flex; align-items: center; gap: 6px; font-family: inherit; text-decoration: none; }
    .btn-cancel-item:hover { background-color: #f12828 !important; color: white; transition: 0.7s; border-color: #ef4444; }
    .btn-cancel-disabled { background-color: #f3f4f6; color: #9ca3af; border: 1px solid #e5e7eb; padding: 6px 14px; border-radius: 6px; font-size: 0.875rem; font-weight: 600; cursor: not-allowed; display: inline-flex; align-items: center; gap: 6px; font-family: inherit; text-decoration: none; }

    @media (max-width: 768px) {
        .custom-hero-title { font-size: 2.5rem; }
        .card-header, .card-footer { flex-direction: column; align-items: flex-start; }
        .filter-group-wrapper { width: 100%; }
        .filter-select { flex: 1; }
        .reset-btn { width: 100%; justify-content: center; background: var(--border-color); }
        .footer-action-group { width: 100%; justify-content: space-between; margin-top: 8px; }
        .footer-stat[style*="text-align: right"] { text-align: left !important; }
    }
</style>

<section class="custom-img-hero-section">
    <div class="custom-hero-overlay"></div>
    <div class="custom-hero-content">
        <h1 class="custom-hero-title">We're here to help</h1>
        <p class="custom-hero-subtitle">Everything you need to know about dining with us.</p>
    </div>
    <div class="custom-hero-gold-bar"></div>
</section>

<div class="container-wrapper">

    <!-- <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">🛍️</div>
            <div class="stat-details">
                <span class="stat-value">12</span>
                <span class="stat-label">Total Orders</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">💳</div>
            <div class="stat-details">
                <span class="stat-value">₹3,450</span>
                <span class="stat-label">Total Spent</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🪑</div>
            <div class="stat-details">
                <span class="stat-value">3</span>
                <span class="stat-label">Tables Booked</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⭐</div>
            <div class="stat-details">
                <span class="stat-value">4</span>
                <span class="stat-label">Favorites Saved</span>
            </div>
        </div>
    </div> -->

    <!-- ORDERS SECTION -->
    <div class="section-header">
        <div class="section-title">
            <i class="fas fa-shopping-bag"></i> Your Orders
        </div>
        <div class="filter-group-wrapper">
            <input type="text" id="order-id-search" class="filter-select" placeholder="Search Order ID (e.g. 10)">
            <select id="payment-filter" class="filter-select">
                <option value="all">All Payments</option>
                <option value="net banking">Net Banking</option>
                <option value="cash">Cash</option>
            </select>
            <select id="status-filter" class="filter-select">
                <option value="all">All Status</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <button class="reset-btn" id="reset-orders-btn">
                <i class="fas fa-undo"></i> Reset
            </button>
        </div>
    </div>

    <div class="list-container" id="orders-container">
        <?php
        $allorders = Allorders();
        if (!empty($allorders)) {
            foreach ($allorders as $order) {
                $paymentMethod = strtolower(trim($order['payment_method']));
                $orderStatus = strtolower(trim($order['order_status']));

                $payClass = ($paymentMethod == 'cash') ? 'badge-cod' : 'badge-paid';

                $statusClass = 'badge-pending';
                if ($orderStatus == 'processing') $statusClass = 'badge-processing';
                if ($orderStatus == 'completed') $statusClass = 'badge-completed';
                if ($orderStatus == 'cancelled') $statusClass = 'badge-cancel';
        ?>
            <div class="data-card order-card" data-id="<?php echo $order['id']; ?>" data-payment="<?php echo $paymentMethod; ?>" data-status="<?php echo $orderStatus; ?>">
                <div class="card-header">
                    <div class="card-id-block">
                        <span class="card-id">#ORD ID: <?php echo $order['id']; ?></span>
                        <span class="card-date"><?php echo date('d M, Y  h:i A', strtotime($order['created_at'])); ?></span>
                    </div>
                    <div class="card-badges">
                        <span class="badge px-3 py-2 <?php echo $payClass; ?>"><?php echo $order['payment_method']; ?></span>
                        <span class="badge <?php echo $statusClass; ?>"><?php echo ucfirst($order['order_status']); ?></span>
                    </div>
                </div>
                <?php $pdetails = productdetails($order['product_id']); ?>
                <div class="card-body">
                    <div class="item-image">
                        <img src="./upload/<?php echo $pdetails['image'] ?>" alt="Item Image">
                    </div>
                    <div class="item-details">
                        <h3 class="item-name"><strong><?php echo $pdetails['name']; ?></strong> </h3>
                        <p class="item-meta"><strong class="text-black"> Description:</strong> <?php echo $pdetails['description']; ?></p>
                        <span class="item-qty">Qty: <?php echo $order['quantity']; ?></span>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="footer-stat">
                        <span class="footer-stat-label">Price per unit</span>
                        <span class="footer-stat-value">₹<?php echo $order['price']; ?></span>
                    </div>
                    <div class="footer-action-group">
                        <div class="footer-stat" style="text-align: right;">
                            <span class="footer-stat-label">Total Amount</span>
                            <span class="footer-stat-value">₹<?php echo $order['total_price']; ?></span>
                        </div>
                        
                        <?php 
                        // Order Cancellation Button Logic
                        if ($orderStatus == 'pending') { 
                        ?>
                            <a href="?cancel_order_id=<?php echo $order['id']; ?>" class="btn-cancel-item" onclick="return confirmCancelOrder(event, this.href);">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        <?php } elseif ($orderStatus == 'processing' || $orderStatus == 'completed') { ?>
                            <button class="btn-cancel-disabled" disabled title="Order cannot be cancelled">
                                <i class="fas fa-ban"></i> Cancel
                            </button>
                        <?php } elseif ($orderStatus == 'cancelled') { ?>
                            <span class="text-danger fw-bold" style="font-size: 0.95rem;">Order Cancelled</span>
                        <?php } ?>
                        
                    </div>
                </div>
            </div>
        <?php 
            } 
        } else {
            echo "<div class='alert alert-info text-center mt-4'>You haven't made any orders yet.</div>";
        }
        ?>
    </div>

    <!-- BOOKINGS SECTION -->
    <div class="section-header" style="margin-top: 60px;">
        <div class="section-title">
            <i class="fas fa-chair"></i> Your Table Reservations
        </div>
        <div class="filter-group-wrapper">
            <select id="booking-status-filter" class="filter-select">
                <option value="all">All Status</option>
                <option value="confirmed">Confirmed</option>
                <option value="completed">Completed</option>
            </select>
            <button class="reset-btn" id="reset-bookings-btn">
                <i class="fas fa-undo"></i> Reset
            </button>
        </div>
    </div>

    <div class="list-container" id="bookings-container">
        <?php
        $allbooking = Allbooking();

        if (!empty($allbooking)) {
            foreach($allbooking as $booking) {
                
                $statusClass = 'badge-pending';
                if ($booking['booking_status'] == 'Confirmed') {
                    $statusClass = 'badge-confirmed';
                } elseif ($booking['booking_status'] == 'Cancelled by Customer' || $booking['booking_status'] == 'Cancelled') {
                    $statusClass = 'badge-cancel'; 
                }

                $decoration = (!empty($booking['decoration_option']) && $booking['decoration_option'] != 'none') 
                              ? htmlspecialchars($booking['decoration_option']) 
                              : 'Standard Table';

                $special_req = !empty($booking['special_requests']) ? htmlspecialchars($booking['special_requests']) : 'None';
        ?>

        <div class="data-card booking-card mb-3">
            <div class="card-header">
                <div class="card-id-block">
                    <span class="card-id">BKG-<?php echo $booking['id']; ?></span>
                    <span class="card-date">
                        Reserved: <?php echo date('d M, Y', strtotime($booking['booking_date'])); ?> 
                        at <?php echo date('h:i A', strtotime($booking['booking_time'])); ?>
                    </span>
                </div>
                <div class="card-badges">
                    <span class="badge <?php echo $statusClass; ?>"><?php echo $booking['booking_status']; ?></span>
                </div>
            </div>
            
            <div class="card-body">
                <div class="item-image"><i class="fas fa-users"></i></div>
                <div class="item-details">
                    <h4 class="item-name"><?php echo $decoration; ?></h4>
                    <p class="item-meta">Special Request: <?php echo $special_req; ?></p>
                    <span class="item-qty">Guests: <?php echo $booking['guests']; ?></span>
                </div>
            </div>
            
            <div class="card-footer">
                <div class="footer-stat">
                    <span class="footer-stat-label">Location</span>
                    <span class="footer-stat-value">Delicious Cafe</span>
                </div>
                <div class="footer-action-group">
                    <div class="footer-stat" style="text-align: right;">
                        <span class="footer-stat-label">Booking Fee</span>
                        <span class="footer-stat-value">
                            ₹<?php echo number_format($booking['booking_amount'], 2); ?> 
                            (<?php echo $booking['payment_status']; ?>)
                        </span>
                    </div>
                    
                    <?php 
                    // Condition: Pending thakle cancel button dekhabe, Confirmed hole disable hobe
                    if (strtolower($booking['booking_status']) == 'pending') { 
                    ?>
                        <a href="?cancel_booking_id=<?php echo $booking['id']; ?>" class="btn-cancel-item" onclick="return confirmCancelBooking(event, this.href);">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    <?php } elseif (strtolower($booking['booking_status']) == 'confirmed') { ?>
                        <button class="btn-cancel-disabled" disabled title="Confirmed bookings cannot be cancelled">
                            <i class="fas fa-ban"></i> Cancel
                        </button>
                    <?php } elseif ($booking['booking_status'] == 'Cancelled by Customer') { ?>
                        <span class="text-danger fw-bold" style="font-size: 0.95rem;">Cancelled by Customer</span>
                    <?php } else { ?>
                        <span class="text-danger fw-bold" style="font-size: 0.95rem;">Booking Cancelled</span>
                    <?php } ?>
                </div>
            </div>
        </div>

        <?php 
            } 
        } else {
            echo "<div class='alert alert-info text-center mt-4'>You haven't made any table bookings yet.</div>";
        }
        ?>
    </div>

</div>

<?php include_once('footer.php') ?>

<script>
    // --- ORDER FILTERS LOGIC ---
    const orderIdSearch = document.getElementById('order-id-search');
    const paymentFilter = document.getElementById('payment-filter');
    const statusFilter = document.getElementById('status-filter');
    const resetOrdersBtn = document.getElementById('reset-orders-btn');

    function updateOrders() {
        const searchId = orderIdSearch.value.trim().toLowerCase();
        const selectedPayment = paymentFilter.value;
        const selectedStatus = statusFilter.value;

        const cards = document.querySelectorAll('#orders-container .order-card');

        cards.forEach(card => {
            let show = true;
            const cardId = card.getAttribute('data-id').toLowerCase();
            const cardPayment = card.getAttribute('data-payment');
            const cardStatus = card.getAttribute('data-status');

            if (searchId !== '' && !cardId.includes(searchId)) show = false;
            if (selectedPayment !== 'all' && cardPayment !== selectedPayment) show = false;
            if (selectedStatus !== 'all' && cardStatus !== selectedStatus) show = false;

            card.style.display = show ? 'flex' : 'none';
        });
    }

    if (orderIdSearch) orderIdSearch.addEventListener('input', updateOrders);
    if (paymentFilter) paymentFilter.addEventListener('change', updateOrders);
    if (statusFilter) statusFilter.addEventListener('change', updateOrders);

    if (resetOrdersBtn) {
        resetOrdersBtn.addEventListener('click', () => {
            if (orderIdSearch) orderIdSearch.value = '';
            if (paymentFilter) paymentFilter.value = 'all';
            if (statusFilter) statusFilter.value = 'all';
            updateOrders();
        });
    }

    // --- BOOKING FILTERS LOGIC ---
    const bookingStatusFilter = document.getElementById('booking-status-filter');
    const resetBookingsBtn = document.getElementById('reset-bookings-btn');

    function updateBookings() {
        const cards = document.querySelectorAll('#bookings-container .booking-card');
        cards.forEach(card => {
            let show = true;

            if (bookingStatusFilter && bookingStatusFilter.value !== 'all') {
                const badges = card.querySelectorAll('.badge');
                let match = Array.from(badges).some(b =>
                    (bookingStatusFilter.value === 'confirmed' && b.classList.contains('badge-confirmed')) ||
                    (bookingStatusFilter.value === 'completed' && b.classList.contains('badge-completed'))
                );
                show = show && match;
            }

            card.style.display = show ? 'flex' : 'none';
        });
    }

    function resetBookingFilters() {
        if (bookingStatusFilter) bookingStatusFilter.value = 'all';
        updateBookings();
    }

    if (bookingStatusFilter) bookingStatusFilter.addEventListener('change', updateBookings);
    if (resetBookingsBtn) resetBookingsBtn.addEventListener('click', resetBookingFilters);

    // Stylish Order Cancellation Confirmation
    function confirmCancelOrder(e, url) {
        if (e) e.preventDefault();
        cafeConfirm('Cancel Order?', 'Are you sure you want to cancel this order? This action cannot be undone.', '<i class="fas fa-times me-1"></i> Yes, Cancel Order', 'Keep Order', 'warning').then(result => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
        return false;
    }

    // Stylish Booking Cancellation Confirmation
    function confirmCancelBooking(e, url) {
        if (e) e.preventDefault();
        cafeConfirm('Cancel Reservation?', 'Are you sure you want to cancel this table booking?', '<i class="fas fa-times me-1"></i> Yes, Cancel Reservation', 'Keep Reservation', 'warning').then(result => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
        return false;
    }
</script>