<style>
    /* ==========================================
       Cafe Theme Variables 
    ========================================== */
    :root {
        --cafe-dark: #342319;
        /* Deep Espresso Brown */
        --cafe-primary: #A67B5B;
        /* Warm Caramel / Coffee */
        --cafe-bg: #FAF8F5;
        /* Warm Creamy Off-White */
        --text-muted-dark: #B0A39A;
        /* Soft greyish brown for text */
    }

    /* ==========================================
       Premium Footer Styling
    ========================================== */
    .footer_main {
        background-color: var(--cafe-dark);
        color: var(--cafe-bg);
        border-top: 3px solid var(--cafe-primary);
        font-family: 'DM Sans', sans-serif;
        padding-top: 3rem;
        padding-bottom: 1.5rem;
    }

    .foot_upper {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: var(--cafe-primary);
        letter-spacing: 1px;
        position: relative;
        padding-bottom: 12px;
        margin-bottom: 25px;
    }

    /* Decorative Line under Headings */
    .foot_upper::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 2px;
        background-color: var(--cafe-primary);
        border-radius: 2px;
    }

    /* Footer Links */
    .foot_li {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .foot_li li {
        margin-bottom: 12px;
    }

    .foot_li a {
        text-decoration: none;
        color: var(--text-muted-dark);
        font-size: 1.05rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
    }

    .foot_li a i {
        margin-right: 8px;
        font-size: 0.8rem;
        color: var(--cafe-primary);
        transition: all 0.3s ease;
    }

    /* Hover Animation for Links */
    .foot_li a:hover {
        color: var(--cafe-primary);
        transform: translateX(8px);
    }

    .foot_li a:hover i {
        transform: translateX(4px);
    }

    /* Contact & Info Text */
    .footer_main p {
        color: var(--text-muted-dark);
        font-size: 1rem;
        margin-bottom: 12px;
    }

    .footer_main p i {
        color: var(--cafe-primary);
        margin-right: 12px;
        font-size: 1.1rem;
    }

    .footer_main h5 {
        color: var(--cafe-bg);
        margin-top: 15px;
        font-family: 'Playfair Display', serif;
    }

    /* Social Icons */
    .btn_foot {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(166, 123, 91, 0.4);
        color: var(--cafe-primary);
        background: transparent;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        text-decoration: none;
        margin-right: 8px;
        margin-top: 10px;
    }

    .btn_foot:hover {
        background: var(--cafe-primary);
        color: #ffffff;
        border-color: var(--cafe-primary);
        transform: translateY(-4px);
        box-shadow: 0 6px 15px rgba(166, 123, 91, 0.3);
    }

    /* Newsletter Input */
    .newsletter-input {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(166, 123, 91, 0.3);
        color: var(--cafe-bg);
        border-radius: 30px;
        padding-left: 20px;
    }

    .newsletter-input:focus {
        border-color: var(--cafe-primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(166, 123, 91, 0.15);
        background: rgba(255, 255, 255, 0.08);
    }

    .newsletter-input::placeholder {
        color: rgba(176, 163, 154, 0.6);
    }

    /* Subscribe Button */
    .foot_sign_up_btn {
        background: linear-gradient(135deg, #A67B5B 0%, #8B5A2B 100%);
        color: #ffffff;
        border: none;
        font-weight: 600;
        border-radius: 30px;
        padding: 0 25px;
        transition: all 0.3s ease;
        top: 4px;
        right: 4px;
        bottom: 4px;
        height: calc(100% - 8px);
    }

    .foot_sign_up_btn:hover {
        background: linear-gradient(135deg, #8B5A2B 0%, #5a2a02 100%);
        transform: scale(0.98);
    }

    /* Copyright Area */
    .copyright-area {
        border-top: 1px solid rgba(166, 123, 91, 0.15);
        margin-top: 3rem;
        padding-top: 1.5rem;
        text-align: center;
    }

    .copyright-text {
        font-size: 0.95rem;
        color: var(--text-muted-dark);
    }

    .copyright-text span {
        color: var(--cafe-primary);
        font-weight: 600;
    }
</style>

<!-- Footer Start -->
<div class="container-fluid footer_main wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <div class="row g-5">

            <!-- Company Links -->
            <div class="col-lg-3 col-md-6">
                <h4 class="foot_upper">Company</h4>
                <ul class="foot_li">
                    <li><a href="index.php"><i class="fa-solid fa-chevron-right"></i> Home</a></li>
                    <li><a href="about_us.php"><i class="fa-solid fa-chevron-right"></i> About Us</a></li>
                    <li><a href="menu.php"><i class="fa-solid fa-chevron-right"></i> Menu</a></li>
                    <li><a href="contact_us.php"><i class="fa-solid fa-chevron-right"></i> Contact</a></li>
                    <li><a href="faq.php"><i class="fa-solid fa-chevron-right"></i> Faq</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6">
                <h4 class="foot_upper">Contact</h4>
                <p><i class="fa fa-map-marker-alt"></i>CCLMS, Contai, India</p>
                <p><i class="bi bi-telephone"></i>+91 12345 67890</p>
                <p><i class="fa fa-envelope"></i>santusau123@gmail.com</p>

                <div class="d-flex mt-3">
                    <a class="btn_foot" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn_foot" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn_foot" href="#"><i class="fab fa-youtube"></i></a>
                    <a class="btn_foot" href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Opening Hours -->
            <div class="col-lg-3 col-md-6">
                <h4 class="foot_upper">Opening</h4>
                <h5>Monday - Saturday</h5>
                <p>09:00 AM - 09:00 PM</p>
                <h5>Sunday</h5>
                <p>10:00 AM - 08:00 PM</p>
            </div>

            <!-- Newsletter -->
            <div class="col-lg-3 col-md-6">
                <h4 class="foot_upper">Newsletter</h4>
                <p>Subscribe to get our latest updates, offers and more.</p>
                <!-- <div class="position-relative mx-auto mt-3" style="max-width: 400px;">
                    <input class="form-control newsletter-input w-100 py-3 pe-5" type="text" placeholder="Your email">
                    <a href="Login_form.php"><button type="button" class="position-absolute foot_sign_up_btn">Sign Up</button></a>
                </div> -->
            </div>

        </div>

        <!-- Copyright -->
        <div class="row copyright-area">
            <div class="col-12">
                <p class="copyright-text mb-0">
                    &copy; <?php echo date("Y"); ?> All Rights Reserved || Developed By <span>Santu Sau</span>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- JS Libraries -->
<script src="asset/bootstrap-5.3.7-dist/js/jquery.min.js"></script>
<script src="asset/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
<script src="java_script.js"></script>


<script>
    // loader of the website


    // Text strings to cycle through
    const loadingTexts = [
        "Waking up the barista...",
        "Grinding fresh beans...",
        "Steaming the milk...",
        "Adding a little love...",
        "Almost ready!"
    ];

    let textIndex = 0;
    const textElement = document.getElementById("loader-text");

    // Change the text every 700 milliseconds
    const textInterval = setInterval(() => {
        textIndex++;
        if (textIndex < loadingTexts.length) {
            // Briefly fade text out, change it, and fade back in
            textElement.style.opacity = 0;
            setTimeout(() => {
                textElement.innerText = loadingTexts[textIndex];
                textElement.style.opacity = 1;
            }, 150);
        }
    }, 700);

    // Your existing load logic with the 2000ms delay
    window.addEventListener("load", function() {
        const loader = document.getElementById("loader-wrapper");

        setTimeout(() => {
            // Stop changing the text
            clearInterval(textInterval);

            // Fade out the loader
            loader.classList.add("fade-out");

            // Remove from DOM after fade transition
            setTimeout(() => {
                loader.remove();
            }, 600); // 600ms matches the CSS transition time

        }, 1000); // Wait 2 seconds as requested
    });

    // loader of the website end



    // Video Playback Rate
    const banner_video = document.getElementById("banner-video");
    if (banner_video) {
        banner_video.playbackRate = 0.5;
    }

    // Contact Info Validation
    function contact_info_validation() {
        let name = document.getElementById("name-field").value;
        let email = document.getElementById("email-field").value;
        let subject = document.getElementById("subject-field").value;
        let mesage = document.getElementById("message-field").value;

        if (name == "" || email == "" || subject == "" || mesage == "") {
            cafeAlert("Fields Required", "All fields are required to send your message!", "warning");
            return false;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            cafeAlert("Invalid Email", "Please enter a valid email address!", "warning");
            return false;
        } else if (subject.length < 10) {
            cafeAlert("Subject Too Short", "Subject must be at least 10 characters long.", "warning");
            return false;
        } else if (mesage.length < 15) {
            cafeAlert("Message Too Short", "Message should be at least 15 characters long.", "warning");
            return false;
        } else {
            return true;
        }
    }

    // Book Table Validation
    function book_your_table() {
        let nm = document.getElementById("nm").value;
        let em = document.getElementById("em").value;
        let dt = document.getElementById("date1").value;
        let t = document.getElementById("time1").value;
        let p = document.getElementById("person").value;

        if (nm == "" || em == "" || dt == "" || t == "") {
            cafeAlert("Fields Required", "All fields are required to reserve your table!", "warning");
            return false;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em)) {
            cafeAlert("Invalid Email", "Please enter a valid email address!", "warning");
            return false;
        } else {
            return true;
        }
    }

    // Feedback Form JS
    const stars = document.querySelectorAll('input[name="star"]');
    const ratingText = document.getElementById('ratingText');

    if (stars && ratingText) {
        stars.forEach(star => {
            star.addEventListener('change', () => {
                let value = star.value;
                if (value == 1) {
                    ratingText.innerHTML = "😞 Poor";
                } else if (value == 2) {
                    ratingText.innerHTML = "😐 Average";
                } else if (value == 3) {
                    ratingText.innerHTML = "🙂 Good";
                } else if (value == 4) {
                    ratingText.innerHTML = "😊 Very Good";
                } else if (value == 5) {
                    ratingText.innerHTML = "😍 Excellent";
                }
            });
        });
    }



    // Bootstrap Form Validation Logic for online reservation
    (function() {
        'use strict'

        var form = document.getElementById('cafeReservationForm');

        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                event.preventDefault(); // Prevent page reload for now

                // If form is valid, call your actual booking function here
                // book_your_table();
                cafeAlert("Form Valid", "Proceeding to payment...", "info");
            }

            form.classList.add('was-validated');
        }, false);
    })();




    document.addEventListener("DOMContentLoaded", function() {
        // Select all the filter buttons
        const filterBtns = document.querySelectorAll('.filter-btn');

        // Add a click event to each button
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {

                // 1. Remove 'active' class from ALL buttons
                filterBtns.forEach(b => b.classList.remove('active'));

                // 2. Add 'active' class to the specific button that was clicked
                this.classList.add('active');

                // Note: Your logic to actually hide/show the menu items based on 
                // the 'data-filter' attribute will go here!
            });
        });
    });
</script>
</body>

</html>