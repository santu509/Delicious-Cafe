<?php
include_once('header.php');

// Ensure session is started if not already started in header.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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
    // Backend Login Validation Check
    if (empty($_SESSION['id'])) {
        echo "<script>window.location.href = 'Login_form.php';</script>";
        exit();
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

    // Execute the query
    if (mysqli_query($connect, $insert_query)) {
        $mailSent = tableBookingMail($full_name, $email, $booking_date, $booking_time, $guests, $decoration_option, $final_booking_amount, $payment_id);

        if ($mailSent) {
            showCafeAlert('Booking Confirmed!', 'Payment Successful! Table booked. A confirmation email has been sent.', 'success', 'index.php');
        } else {
            showCafeAlert('Booking Successful!', 'Payment Successful! Table booked. (Email confirmation could not be sent).', 'success', 'index.php');
        }
    } else {
        // Show actual database error if the insert fails
        $db_error = mysqli_error($connect);
        showCafeAlert('Booking Error', 'Database Error: ' . addslashes($db_error), 'error', 'table_book.php');
        echo "<script>console.error('Database Error: " . addslashes($db_error) . "');</script>";
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

<section class="reservation-section mb-5" style="background-color: #fafaf2;">
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
                    // Assuming userdetails() is available through header.php or another include
                    if (function_exists('userdetails')) {
                        $logged_user = userdetails($_SESSION['id']);
                        if ($logged_user) {
                            $logged_user_name = $logged_user['name'] ?? '';
                            $logged_user_email = $logged_user['email_id'] ?? '';
                        }
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

<script>
    // Check user login status from PHP session
    const isLoggedIn = <?php echo isset($_SESSION['id']) && !empty($_SESSION['id']) ? 'true' : 'false'; ?>;

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
    function payWithRazorpay() {
        // 1. Client-Side Login Check (Stop before triggering Razorpay or Form Validation)
        if (!isLoggedIn) {
            showGuestAlert('Book a Table');
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
                "color": "#BD7753"
            }
        };

        var rzp1 = new Razorpay(options);
        rzp1.on('payment.failed', function(response) {
            cafeAlert('Payment Failed', "Reason: " + response.error.description, 'error');
        });
        rzp1.open();
    }
</script>

<?php include_once('footer.php'); ?>