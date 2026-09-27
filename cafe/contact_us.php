<?php
include("header.php");
include("mail.php");

$success = "";
$error = "";

if (isset($_POST['contact-btn'])) {
    $name    = htmlspecialchars(trim($_POST['name']));
    $email   = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    if (sendmail($name, $email, $subject, $message)) {
        $success = "Message sent successfully!";
    } else {
        $error = "Failed to send message!";
    }
}

?>
<?php
if (isset($_POST['contact-btn'])) {
    global $connect;

    if (!isset($_SESSION['id'])) {
        showCafeAlert('Sign In Required', 'Please finish your registration and log in before sending a message.', 'warning', 'Login_form.php');
    }
    $customer_id = (int)$_SESSION['id'];
    $name = $_SESSION['username'];
    $email = $_SESSION['eid'];

    $msg_subject = mysqli_real_escape_string($connect, $_POST['subject']);
    $message = mysqli_real_escape_string($connect, $_POST['message']);
    $sql = "INSERT INTO contactus
    (customer_id, cname, cemail, subject,message) VALUES ($customer_id,'$name','$email','$msg_subject','$message')";

    $run = mysqli_query($connect, $sql);

    if ($run) {
        showCafeAlert('Message Sent Successfully!', 'Thank you for getting in touch! We will review your message and get back to you shortly.', 'success', 'index.php');
    } else {
        showCafeAlert('Error', 'Failed to send message: ' . mysqli_error($connect), 'error', 'contact_us.php');
    }
}
?>
<style>
    /* ==========================================
       Cafe Theme Variables 
    ========================================== */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap');

    :root {
        --cafe-dark: #2C1E16;
        /* Deep Espresso Brown */
        --cafe-primary: #A67B5B;
        /* Warm Caramel / Coffee */
        --cafe-bg: #FAF8F5;
        /* Warm Creamy Off-White */
        --card-bg: #FFFFFF;
        --text-dark: #3E2723;
        --text-muted: #7A6960;
        --card-shadow: 0 8px 25px rgba(44, 30, 22, 0.06);
    }

    /* ==========================================
       Contact Section Styling
    ========================================== */
    .contact-section {
        background-color: var(--cafe-bg);
        font-family: 'Poppins', sans-serif;
        /* padding: 5rem 0 6rem;  */
        overflow-x: hidden;
        margin-top: 0 !important;
        padding-top: 1%;
    }

    .section-title h1 {
        font-family: 'Playfair Display', serif;
        color: var(--cafe-dark);
        font-weight: 700;
        font-size: 2.8rem;
        /* margin-bottom: 3.5rem; */
        position: relative;
        display: inline-block;
    }

    /* Decorative Line under title */
    .section-title h1::after {
        content: "";
        position: absolute;
        width: 70px;
        height: 3px;
        background-color: var(--cafe-primary);
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 5px;
    }

    /* Information & Form Cards */
    .info-wrap,
    .contact_box {
        background: var(--card-bg);
        padding: 3rem 2.5rem;
        /* Better padding for desktop */
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        height: 100%;
        /* Ensures equal height in row */
        border: 1px solid rgba(166, 123, 91, 0.15);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* Contact Info Items */
    .info-item {
        margin-bottom: 1.8rem;
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }

    .icon-box {
        width: 55px;
        height: 55px;
        background-color: rgba(166, 123, 91, 0.15);
        color: var(--cafe-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .info-item:hover .icon-box {
        background-color: var(--cafe-primary);
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(166, 123, 91, 0.3);
    }

    .info-content h3 {
        font-size: 1.2rem;
        color: var(--cafe-dark);
        font-weight: 600;
        margin-bottom: 5px;
    }

    .info-content p {
        color: var(--text-muted);
        font-size: 1rem;
        margin: 0;
    }

    /* Map Styling */
    .map-container {
        border-radius: 15px;
        overflow: hidden;
        margin-top: auto;
        /* Pushes map to the bottom if there's extra space */
        border: 1px solid rgba(166, 123, 91, 0.2);
    }

    /* Form Styling */
    .contact_box h2 {
        font-family: 'Playfair Display', serif;
        color: var(--cafe-dark);
        font-size: 2.2rem;
        margin-bottom: 2rem;
        text-align: center;
    }

    .form-label {
        color: var(--text-dark);
        font-weight: 500;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border: 1px solid rgba(166, 123, 91, 0.3);
        border-radius: 12px;
        padding: 14px 15px;
        font-size: 1rem;
        background-color: #FAF8F5;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--cafe-primary);
        box-shadow: 0 0 0 4px rgba(166, 123, 91, 0.15);
        background-color: #fff;
        outline: none;
    }

    /* Premium Submit Button */
    .btn-cafe-submit {
        background: linear-gradient(135deg, #793b04 0%, #5a2a02 100%);
        color: #ffffff;
        border: none;
        padding: 14px 40px;
        border-radius: 30px;
        font-size: 1.05rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 6px 15px rgba(121, 59, 4, 0.2);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        margin-top: 15px;
    }

    .btn-cafe-submit::after {
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

    .btn-cafe-submit:hover {
        background: linear-gradient(135deg, #e67e22 0%, #cc6607 100%);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(204, 102, 7, 0.35);
        color: #ffffff;
    }

    .btn-cafe-submit:hover::after {
        left: 150%;
    }

    .btn-cafe-submit:active {
        transform: translateY(1px) scale(0.98);
    }

    /* Responsive Adjustments */
    @media (max-width: 991px) {
        .info-wrap {
            margin-bottom: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .contact-section {
            padding: 1rem 0;
        }

        .info-wrap,
        .contact_box {
            padding: 2rem 1.5rem;
        }

        .section-title h1 {
            font-size: 2.2rem;
        }

        .contact_box h2 {
            font-size: 1.8rem;
        }
    }

    /* ===============================
   Premium Loading Overlay
================================ */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(250, 248, 245, 0.96);
        backdrop-filter: blur(5px);
        display: none;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        z-index: 999999;
    }

    .coffee-loader {
        width: 80px;
        height: 80px;
        border: 6px solid #e6d7c8;
        border-top: 6px solid #793b04;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    .loader-title {
        margin-top: 20px;
        color: #793b04;
        font-size: 22px;
        font-weight: 700;
    }

    .loader-subtitle {
        color: #8a6a54;
        font-size: 14px;
        margin-top: 5px;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    /* media for map */
@media only screen and (max-width: 991px) {
     iframe {
        max-width: 350px!important;
        max-height: 220px;
    }
   
}
</style>

<!-- Contact Section -->
<section id="contact" class="contact-section">

    <!-- Section Title -->
    <div class="container text-center" data-aos="fade-up">
        <div class="section-title">
            <h1>Contact Info</h1>
        </div>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <!-- Added gx-lg-5 for horizontal desktop gap and align-items-stretch for equal heights -->
        <div class="row gy-4 gx-lg-5 align-items-stretch">

            <!-- Contact Details -->
            <div class="col-lg-5">
                <div class="info-wrap">

                    <div class="info-item" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon-box">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div class="info-content">
                            <h3>Address</h3>
                            <p>CCLMS, Contai, India</p>
                        </div>
                    </div>

                    <div class="info-item" data-aos="fade-up" data-aos-delay="300">
                        <div class="icon-box">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div class="info-content">
                            <h3>Call Us</h3>
                            <p>+91 7797913726</p>
                        </div>
                    </div>
                    <div class="info-item" data-aos="fade-up" data-aos-delay="300">
                        <div class="icon-box">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                        <div class="info-content">
                            <h3>WhatsApp Us</h3>
                            <p>+91 7797913726</p>
                        </div>
                    </div>

                    <div class="info-item" data-aos="fade-up" data-aos-delay="400">
                        <div class="icon-box">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="info-content">
                            <h3>Email Us</h3>
                            <p>santusau2006@gmail.com</p>
                        </div>
                    </div>

                    <!-- Responsive Map (Width 100%) -->
                    <div class="map-container mt-4" data-aos="fade-up" data-aos-delay="500">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3704.885632941286!2d87.73476217505369!3d21.784686880060512!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a0326f87e6e8479%3A0xb610eefe9d9387c1!2sContai%20College%20of%20Learning%20%26%20Management%20Science!5e0!3m2!1sen!2sin!4v1766326887680!5m2!1sen!2sin" width="100%" height="280px" style="border: 0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                </div>
            </div>

            <!-- Contact Form -->

            <div class="col-lg-7">
                <div class="contact_box">
                    <h2>Get In Touch</h2>
                    <?php if (!empty($success)) { ?>
                        <div class="alert alert-success">
                            <?php echo $success; ?>
                        </div>
                    <?php } ?>

                    <?php if (!empty($error)) { ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php } ?>
                    <form method="POST"
                        action=""
                        enctype="multipart/form-data"
                        onsubmit="if(<?php echo isset($_SESSION['id']) ? 'true' : 'false'; ?>) { return typeof contact_info_validation === 'function' ? contact_info_validation() : true; } else { showGuestAlert('Send Message'); return false; }">
                        <div class="row gy-3">

                            <div class="col-md-6">
                                <label for="name-field" class="form-label">Your Name</label>
                                <input type="text" name="name" id="name-field" class="form-control" value="<?php echo  $_SESSION['username'] ?? ''; ?>">
                            </div>

                            <div class="col-md-6">
                                <label for="email-field" class="form-label">Your Email</label>
                                <input type="email" class="form-control" name="email" id="email-field" value="<?php echo  $_SESSION['eid'] ?? ''; ?>">
                            </div>

                            <div class="col-md-12 mt-3">
                                <label for="subject-field" class="form-label">Subject</label>
                                <input type="text" class="form-control" name="subject" id="subject-field" required="">
                            </div>

                            <div class="col-md-12 mt-3">
                                <label for="message-field" class="form-label">Message</label>
                                <textarea class="form-control" name="message" rows="6" id="message-field" required="" style="resize: none;"></textarea>
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn-cafe-submit" name="contact-btn">
                                    <i class="bi bi-send"></i> Send Message
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div><!-- End Contact Form -->

        </div>
    </div>
    <div class="loading-overlay" id="loadingOverlay">

        <div class="coffee-loader"></div>

        <div class="loader-title">
            Brewing Your Message ☕
        </div>

        <div class="loader-subtitle">
            Please wait while we contact the admin...
        </div>

    </div>
</section>
<!-- /Contact Section -->

<?php include("footer.php") ?>