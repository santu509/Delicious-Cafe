<?php
include_once('Dashboard.php');
global $connect;
// Ensure your database connection file is included here if it's not inside Dashboard.php
if (!$connect) {
    include '../connection.php';
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/PHPMailer/src/Exception.php';
require_once '../vendor/PHPMailer/src/PHPMailer.php';
require_once '../vendor/PHPMailer/src/SMTP.php';

// ---------------------------------------------------------
// --- Status Update Mail Function ---
// ---------------------------------------------------------
if (!function_exists('statusUpdateMail')) {
    function statusUpdateMail($customerName, $customerEmail, $bookingDate, $bookingTime, $newStatus)
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
            $mail->Subject = "Booking Status Update: " . $newStatus . " - Cafe Website";

            if ($newStatus == 'Confirmed') {
                $color = '#10b981'; // Green
                $msg = "Great news! Your table booking has been <b>Confirmed</b>.";
            } elseif ($newStatus == 'Cancelled' || $newStatus == 'Cancelled by Customer') {
                $color = '#ef4444'; // Red
                $msg = "We regret to inform you that your table booking has been <b>Cancelled</b>.";
            } else {
                $color = '#f59e0b'; // Orange
                $msg = "Your table booking status has been updated to: <b>{$newStatus}</b>.";
            }

            $mail->Body = "
            <div style='font-family:Arial;padding:20px; border:1px solid #ddd; border-radius:10px;'>
                <h2 style='color: {$color};'>Booking Status: {$newStatus}</h2>
                <p>Hello <b>{$customerName}</b>,</p>
                <p>{$msg}</p>
                
                <hr style='border:1px solid #eee;'>
                
                <p><b>Booking Date :</b> {$bookingDate}</p>
                <p><b>Booking Time :</b> {$bookingTime}</p>
                
                <hr style='border:1px solid #eee;'>
                
                <p>If you have any questions, feel free to contact us.</p>
                <br>
                <h3>Thank you,<br>Delicious Cafe ☕</h3>
            </div>
            ";

            return $mail->send();
        } catch (Exception $e) {
            return false;
        }
    }
}

// ---------------------------------------------------------
// ADD NEW BOOKING LOGIC
// ---------------------------------------------------------
if (isset($_POST['add_booking'])) {
    $full_name = mysqli_real_escape_string($connect, $_POST['full_name']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $booking_date = mysqli_real_escape_string($connect, $_POST['booking_date']);
    $booking_time = mysqli_real_escape_string($connect, $_POST['booking_time']);
    $guests = intval($_POST['guests']);
    $decoration_option = mysqli_real_escape_string($connect, $_POST['decoration_option']);
    $booking_amount = floatval($_POST['booking_amount']);
    $special_requests = mysqli_real_escape_string($connect, $_POST['special_requests']);
    $booking_status = mysqli_real_escape_string($connect, $_POST['booking_status']);
    $payment_status = mysqli_real_escape_string($connect, $_POST['payment_status']);

    $insert_query = "INSERT INTO tablebook (full_name, email, booking_date, booking_time, guests, decoration_option, booking_amount, special_requests, booking_status, payment_status) 
                     VALUES ('$full_name', '$email', '$booking_date', '$booking_time', $guests, '$decoration_option', $booking_amount, '$special_requests', '$booking_status', '$payment_status')";

    if (mysqli_query($connect, $insert_query)) {
        echo "<script>alert('New booking added successfully!'); window.location.href='Table_Book.php';</script>";
    } else {
        $db_error = mysqli_error($connect);
        // Alert and redirect back to avoid leaving the admin with a blank page on failure
        echo "<script>alert('Database Error: " . addslashes($db_error) . "'); window.location.href='Table_Book.php';</script>";
    }
    exit;
}

// ---------------------------------------------------------
// UPDATE STATUS LOGIC (Updated to send email)
// ---------------------------------------------------------
if (isset($_POST['update_status'])) {
    $booking_id = intval($_POST['booking_id']);
    $new_status = mysqli_real_escape_string($connect, $_POST['booking_status']);

    $update_query = "UPDATE tablebook SET booking_status = '$new_status' WHERE id = $booking_id";
    if (mysqli_query($connect, $update_query)) {

        $fetch_user = mysqli_query($connect, "SELECT full_name, email, booking_date, booking_time FROM tablebook WHERE id = $booking_id");

        if ($user_data = mysqli_fetch_assoc($fetch_user)) {
            $u_name = $user_data['full_name'];
            $u_email = $user_data['email'];
            $b_date = date('d M, Y', strtotime($user_data['booking_date']));
            $b_time = date('h:i A', strtotime($user_data['booking_time']));

            $mailSent = statusUpdateMail($u_name, $u_email, $b_date, $b_time, $new_status);

            if ($mailSent) {
                echo "<script>alert('Booking status updated and email sent to user!'); window.location.href='Table_Book.php';</script>";
            } else {
                echo "<script>alert('Booking status updated, but failed to send email!'); window.location.href='Table_Book.php';</script>";
            }
        } else {
            echo "<script>alert('Booking status updated! (User details not found for email)'); window.location.href='Table_Book.php';</script>";
        }
    } else {
        echo "<script>alert('Database update failed!'); window.location.href='Table_Book.php';</script>";
    }
    exit;
}

// ---------------------------------------------------------
// FILTER LOGIC 
// ---------------------------------------------------------
$where_conditions = ["1=1"];

$limit = isset($_POST['limit']) ? intval($_POST['limit']) : 10;
$date_range = isset($_POST['date_range']) ? $_POST['date_range'] : 'All Time';
$filter_status = isset($_POST['filter_status']) ? $_POST['filter_status'] : 'All Statuses';
$filter_payment = isset($_POST['filter_payment']) ? $_POST['filter_payment'] : 'All Methods';

if ($date_range == 'Today') {
    $where_conditions[] = "booking_date = CURDATE()";
} elseif ($date_range == 'This Week') {
    $where_conditions[] = "YEARWEEK(booking_date, 1) = YEARWEEK(CURDATE(), 1)";
}
if ($filter_status != 'All Statuses') {
    $safe_status = mysqli_real_escape_string($connect, $filter_status);
    $where_conditions[] = "booking_status = '$safe_status'";
}
if ($filter_payment != 'All Methods') {
    $safe_payment = mysqli_real_escape_string($connect, $filter_payment);
    $where_conditions[] = "payment_status = '$safe_payment'";
}
$where_clause = "WHERE " . implode(" AND ", $where_conditions);

// ---------------------------------------------------------
// KPI CALCULATIONS (From Database)
// ---------------------------------------------------------
$query_total = mysqli_query($connect, "SELECT COUNT(id) as count FROM tablebook");
$total_bookings = mysqli_fetch_assoc($query_total)['count'] ?? 0;

$query_revenue = mysqli_query($connect, "SELECT SUM(booking_amount) as total FROM tablebook WHERE booking_status != 'Cancelled' AND booking_status != 'Cancelled by Customer'");
$total_revenue = mysqli_fetch_assoc($query_revenue)['total'] ?? 0;

$query_confirmed = mysqli_query($connect, "SELECT COUNT(id) as count FROM tablebook WHERE booking_status = 'Confirmed'");
$confirmed_bookings = mysqli_fetch_assoc($query_confirmed)['count'] ?? 0;

$query_pending = mysqli_query($connect, "SELECT COUNT(id) as count FROM tablebook WHERE booking_status = 'Pending'");
$pending_bookings = mysqli_fetch_assoc($query_pending)['count'] ?? 0;

// ---------------------------------------------------------
// FETCH TABLE DATA
// ---------------------------------------------------------
$fetch_query = "SELECT * FROM tablebook $where_clause ORDER BY booking_date DESC, booking_time DESC LIMIT $limit";
$result_data = mysqli_query($connect, $fetch_query);

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .Dashboard-right {
        width: 84%;
        float: right;
        background-color: #f4f6f9;
        min-height: 100vh;
        padding: 20px 30px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .table_header th {
        color: black;
        background-color: #4a2c03;
    }

    .page-title {
        color: #1a233a;
        font-weight: 700;
        font-size: 1.8rem;
    }

    .kpi-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 100%;
    }

    .kpi-title {
        font-size: 0.8rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }

    .kpi-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #212529;
        margin: 0;
    }

    .icon-box {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .icon-blue {
        background-color: #eaf2ff;
        color: #4378ff;
    }

    .icon-green {
        background-color: #e8f9f4;
        color: #20c997;
    }

    .icon-orange {
        background-color: #fff4e5;
        color: #ff9800;
    }

    .icon-purple {
        background-color: #f4e8ff;
        color: #9c27b0;
    }

    .filter-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        border: 1px solid #eaeaea;
    }

    .filter-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        margin-bottom: 5px;
        display: block;
    }

    .btn-apply {
        background-color: #5c3a21;
        color: white;
        font-weight: 600;
        border: none;
    }

    .btn-apply:hover {
        background-color: #4a2e1a;
        color: white;
    }

    .btn-reset {
        background-color: #f1f3f5;
        color: #495057;
        font-weight: 600;
        border: 1px solid #dee2e6;
    }

    .table-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        overflow: hidden; 
    }

    .custom-table {
        margin-bottom: 0;
        min-width: 900px;
    }

    .custom-table thead {
        background-color: #5c3a21;
    }

    .custom-table thead th {
        color: #fff;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        padding: 16px;
        border: none;
        letter-spacing: 0.5px;
    }

    .custom-table tbody td {
        vertical-align: middle;
        color: #495057;
        font-size: 0.95rem;
        border-bottom: 1px solid #f1f3f5;
    }

    .order-id {
        color: #5c3a21;
        font-weight: 700;
        font-size: 1rem;
    }

    .customer-name {
        font-weight: 700;
        color: #2b3445;
    }

    .soft-badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.8rem;
        white-space: nowrap;
    }

    .badge-cancelled {
        background-color: #fee2e2;
        color: #ef4444;
    }

    .badge-confirmed {
        background-color: #d1fae5;
        color: #10b981;
    }

    .badge-pending {
        background-color: #fef3c7;
        color: #f59e0b;
    }

    .pay-badge {
        padding: 4px 10px;
        border-radius: 4px;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .pay-cash {
        background-color: #e0f2fe;
        color: #0284c7;
    }

    .pay-net {
        background-color: #f3e8ff;
        color: #7e22ce;
    }

    .pay-failed {
        background-color: #ffe4e6;
        color: #e11d48;
    }

    .action-select {
        border-radius: 6px;
        border: 1px solid #dee2e6;
        font-size: 0.85rem;
        padding: 5px 30px 5px 10px;
        color: #495057;
        width: auto;
    }

    /* --- Mobile Responsive CSS --- */
    @media (max-width: 1024px) {
        .Dashboard-right {
            width: 100%;
            float: none;
        }
    }

    @media (max-width: 768px) {
        .Dashboard-right {
            padding: 15px !important;
        }
        .page-title {
            font-size: 1.4rem;
            text-align: center;
            margin-bottom: 15px !important;
        }
        .header-section {
            justify-content: center !important;
        }
        .kpi-card {
            padding: 15px;
            margin-bottom: 5px;
        }
        .kpi-value {
            font-size: 1.5rem;
        }
        .filter-card {
            padding: 15px;
            margin-bottom: 15px;
        }
        .btn-apply,
        .btn-reset {
            width: 100%;
            text-align: center;
            justify-content: center;
        }
        .custom-table tbody td,
        .custom-table thead th {
            padding: 12px;
        }
        .action-select {
            min-width: 110px;
        }
    }
</style>

<div class="Dashboard-right ps-2 ps-md-4 ps-lg-5 pe-2 pe-md-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center header-section mb-4 gap-3">
        <h2 class="page-title mb-0" style="color: #512d04; font-weight: bold;">Table Booking Management</h2>
        <button class="btn btn-apply px-4 py-2 w-sm-100" data-bs-toggle="modal" data-bs-target="#addBookingModal">
            <i class="fa-solid fa-plus me-2"></i>Add Booking
        </button>
    </div>

    <div class="row g-3 g-md-4 mb-4">
         <div class="col-6 col-md-3">
            <div class="kpi-card border-top border-info border-4">
                <div>
                    <div class="kpi-title">Total Bookings</div>
                    <div class="kpi-value"><?php echo $total_bookings; ?></div>
                </div>
                <div class="icon-box icon-blue d-none d-sm-flex"><i class="fa-solid fa-calendar-check"></i></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="kpi-card border-top border-success border-4">
                <div>
                    <div class="kpi-title">Total Revenue</div>
                    <div class="kpi-value">₹<?php echo number_format($total_revenue, 2); ?></div>
                </div>
                <div class="icon-box icon-green d-none d-sm-flex"><i class="fa-solid fa-chart-line"></i></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="kpi-card border-top border-warning border-4">
                <div>
                    <div class="kpi-title">Confirmed</div>
                    <div class="kpi-value"><?php echo $confirmed_bookings; ?></div>
                </div>
                <div class="icon-box icon-orange d-none d-sm-flex"><i class="fa-solid fa-money-bill-wave"></i></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="kpi-card border-top border-primary border-4">
                <div>
                    <div class="kpi-title">Pending</div>
                    <div class="kpi-value"><?php echo $pending_bookings; ?></div>
                </div>
                <div class="icon-box icon-purple d-none d-sm-flex"><i class="fa-solid fa-spinner"></i></div>
            </div>
        </div>
    </div>

    <div class="filter-card">
        <form method="POST" action="" class="row align-items-end g-3">
            <div class="col-12 col-sm-6 col-md-2">
                <label class="filter-label">Show Rows</label>
                <select name="limit" class="form-select text-secondary">
                    <option value="10" <?php if ($limit == 10) echo 'selected'; ?>>10</option>
                    <option value="25" <?php if ($limit == 25) echo 'selected'; ?>>25</option>
                    <option value="50" <?php if ($limit == 50) echo 'selected'; ?>>50</option>
                    <option value="100" <?php if ($limit == 100) echo 'selected'; ?>>100</option>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-2">
                <label class="filter-label">Date Range</label>
                <select name="date_range" class="form-select text-secondary">
                    <option value="All Time" <?php if ($date_range == 'All Time') echo 'selected'; ?>>All Time</option>
                    <option value="Today" <?php if ($date_range == 'Today') echo 'selected'; ?>>Today</option>
                    <option value="This Week" <?php if ($date_range == 'This Week') echo 'selected'; ?>>This Week</option>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-2">
                <label class="filter-label">Booking Status</label>
                <select name="filter_status" class="form-select text-secondary">
                    <option value="All Statuses" <?php if ($filter_status == 'All Statuses') echo 'selected'; ?>>All Statuses</option>
                    <option value="Pending" <?php if ($filter_status == 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Confirmed" <?php if ($filter_status == 'Confirmed') echo 'selected'; ?>>Confirmed</option>
                    <option value="Cancelled" <?php if ($filter_status == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                    <option value="Cancelled by Customer" <?php if ($filter_status == 'Cancelled by Customer') echo 'selected'; ?>>Cancelled by Customer</option>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-2">
                <label class="filter-label">Payment</label>
                <select name="filter_payment" class="form-select text-secondary">
                    <option value="All Methods" <?php if ($filter_payment == 'All Methods') echo 'selected'; ?>>All Methods</option>
                    <option value="Paid" <?php if ($filter_payment == 'Paid') echo 'selected'; ?>>Paid</option>
                    <option value="Pending" <?php if ($filter_payment == 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Failed" <?php if ($filter_payment == 'Failed') echo 'selected'; ?>>Failed</option>
                </select>
            </div>
            <div class="col-12 col-md-4 col-lg-3 d-flex flex-column flex-sm-row gap-2 mt-3 mt-md-0">
                <button type="submit" class="btn btn-apply px-4 flex-grow-1"><i class="fa-solid fa-filter me-2"></i>Apply</button>
                <a href="" class="btn btn-reset px-4 text-decoration-none d-flex align-items-center flex-grow-1"><i class="fa-solid fa-rotate-right me-2"></i>Reset</a>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table custom-table table-hover align-middle">
                <thead>
                    <tr class="table_header">
                        <th class="text-center">SL.NO</th>
                        <th class="">BOOKING ID</th>
                        <th>DATE</th>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>DETAILS</th>
                        <th>TOTAL</th>
                        <th>PAYMENT</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result_data) > 0) {
                        $sl = 1;
                        while ($row = mysqli_fetch_assoc($result_data)):
                    ?>
                            <tr>
                                <td class="text-center fw-bold text-dark"><?php echo $sl++; ?></td>
                                <td class="order-id">#BKG-<?php echo $row['id']; ?></td>
                                <td>
                                    <div class="text-dark mb-1"><?php echo date('d M, Y', strtotime($row['booking_date'])); ?></div>
                                    <div class="text-muted small"><?php echo date('h:i A', strtotime($row['booking_time'])); ?></div>
                                </td>
                                <td class="customer-name"><?php echo htmlspecialchars($row['full_name']); ?></td>
                                <td class="text-muted"><?php echo htmlspecialchars($row['email']); ?></td>
                                <td>
                                    <div class="fw-bold text-dark mb-1"><?php echo !empty($row['decoration_option']) ? htmlspecialchars($row['decoration_option']) : 'Standard Table'; ?></div>
                                    <div class="text-muted small">Guests: <?php echo htmlspecialchars($row['guests']); ?></div>
                                    <div class="text-muted small">Request: <?php echo htmlspecialchars($row['special_requests']); ?></div>
                                </td>
                                <td class="fw-bold text-dark">₹<?php echo number_format($row['booking_amount'], 2); ?></td>
                                <td>
                                    <?php
                                    if ($row['payment_status'] == 'Paid') {
                                        echo '<span class="pay-badge pay-net">PAID</span>';
                                        if (!empty($row['payment_id'])) {
                                            echo '<div class="text-muted mt-1" style="font-size: 0.7rem;">ID: ' . htmlspecialchars($row['payment_id']) . '</div>';
                                        }
                                    } elseif ($row['payment_status'] == 'Failed') {
                                        echo '<span class="pay-badge pay-failed">FAILED</span>';
                                    } else {
                                        echo '<span class="pay-badge pay-cash">PENDING</span>';
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $status = $row['booking_status'];
                                    $badgeClass = 'badge-pending';
                                    if ($status == 'Confirmed') {
                                        $badgeClass = 'badge-confirmed';
                                    } elseif ($status == 'Cancelled' || $status == 'Cancelled by Customer') {
                                        $badgeClass = 'badge-cancelled';
                                    }
                                    ?>
                                    <span class="soft-badge <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($status); ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if ($status == 'Cancelled by Customer') { ?>
                                        <span class="text-danger fw-bold" style="font-size: 0.85rem;">Cancelled by User</span>
                                    <?php } else { ?>
                                        <form method="POST" action="" style="display: inline-block; margin: 0;">
                                            <input type="hidden" name="update_status" value="1">
                                            <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                                            <select name="booking_status" class="form-select action-select" onchange="this.form.submit()">
                                                <option value="Pending" <?php echo ($status == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                <option value="Confirmed" <?php echo ($status == 'Confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                                                <option value="Cancelled" <?php echo ($status == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                            </select>
                                        </form>
                                    <?php } ?>
                                </td>
                            </tr>
                    <?php
                        endwhile;
                    } else {
                        echo '<tr><td colspan="10" class="text-center text-muted py-4">No bookings found for the selected filters.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ADD BOOKING MODAL -->
    <div class="modal fade" id="addBookingModal" tabindex="-1" aria-labelledby="addBookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="addBookingModalLabel"><i class="fa-solid fa-calendar-plus me-2 text-primary"></i>Add New Table Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Action left empty to submit to same page -->
                <form method="POST" action="">
                    <!-- Hidden field to ensure add_booking is always sent in POST body -->
                    <input type="hidden" name="add_booking" value="1">
                    
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="full_name" class="form-control" required placeholder="Enter customer name">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required placeholder="customer@example.com">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold">Booking Date <span class="text-danger">*</span></label>
                                <input type="date" name="booking_date" class="form-control" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold">Booking Time <span class="text-danger">*</span></label>
                                <input type="time" name="booking_time" class="form-control" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold">Number of Guests <span class="text-danger">*</span></label>
                                <input type="number" name="guests" class="form-control" required min="1">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold">Decoration Option</label>
                                <select name="decoration_option" class="form-select">
                                    <option value="">Standard Table (No Decoration)</option>
                                    <option value="Birthday Theme">Birthday Theme</option>
                                    <option value="Anniversary Theme">Anniversary Theme</option>
                                    <option value="Candlelight Dinner">Candlelight Dinner</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label fw-bold">Booking Amount (₹) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="booking_amount" class="form-control" required placeholder="0.00">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label fw-bold">Booking Status</label>
                                <select name="booking_status" class="form-select">
                                    <option value="Pending">Pending</option>
                                    <option value="Confirmed">Confirmed</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label fw-bold">Payment Status</label>
                                <select name="payment_status" class="form-select">
                                    <option value="Pending">Pending</option>
                                    <option value="Paid">Paid</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Special Requests</label>
                                <textarea name="special_requests" class="form-control" rows="2" placeholder="Any special dietary requirements or arrangements?"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary w-sm-100" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_booking" class="btn btn-apply w-sm-100">Save Booking</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- Corrected Bootstrap JS path to load correctly relative to the project directory -->
<script src="../asset/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>