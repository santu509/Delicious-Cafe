<?php include_once('Ui-All-Function.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Classic Cold Coffee</title>

  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <link rel="stylesheet" href="asset/bootstrap-5.3.7-dist/css/bootstrap.min.css">

  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

  <style>
    /* ==========================================
       CAFE THEME VARIABLES
    ========================================== */
    :root {
      --cafe-dark: #2C1E16;
      /* Deep Espresso Brown */
      --cafe-primary: #A67B5B;
      /* Warm Caramel / Coffee */
      --cafe-bg: #FAF8F5;
      /* Warm Creamy Off-White */
      --text-dark: #3E2723;
      --text-muted: #7A6960;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      min-height: 100vh;
      background-color: var(--cafe-bg);
      display: flex;
      align-items: center;
      justify-content: center;
      overflow-x: hidden;
      position: relative;
      padding: 20px;
      color: var(--text-dark);
    }

    /* Soft Warm Glowing Orbs */
    body::before {
      content: "";
      position: fixed;
      width: 450px;
      height: 450px;
      background: rgba(166, 123, 91, 0.15);
      /* Caramel Blur */
      border-radius: 50%;
      filter: blur(100px);
      top: -100px;
      left: -100px;
      z-index: -1;
    }

    body::after {
      content: "";
      position: fixed;
      width: 450px;
      height: 450px;
      background: rgba(139, 56, 4, 0.1);
      /* Coffee Blur */
      border-radius: 50%;
      filter: blur(120px);
      bottom: -100px;
      right: -100px;
      z-index: -1;
    }

    /* Premium Light Glassmorphism Card */
    .product-card {
      width: 950px;
      max-width: 100%;
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(20px);
      border-radius: 25px;
      padding: 40px;
      display: grid;
      grid-template-columns: 1fr 1.1fr;
      gap: 45px;
      border: 1px solid rgba(166, 123, 91, 0.2);
      box-shadow: 0 25px 60px rgba(44, 30, 22, 0.08);
      position: relative;
      animation: fadeIn .8s ease forwards;
    }

    /* Close Button Styling */
    .close-btn {
      position: absolute;
      top: 25px;
      right: 25px;
      width: 40px;
      height: 40px;
      background: #FFFFFF;
      border: 1px solid rgba(166, 123, 91, 0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 18px;
      transition: all 0.3s ease;
      z-index: 10;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .close-btn a {
      color: var(--cafe-primary);
      text-decoration: none;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      height: 100%;
    }

    .close-btn:hover {
      background: #dc3545;
      border-color: #dc3545;
      transform: rotate(90deg) scale(1.1);
      box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
    }

    .close-btn:hover a {
      color: white;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: scale(.95);
      }

      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    @keyframes fadeOut {
      from {
        opacity: 1;
        transform: scale(1);
      }

      to {
        opacity: 0;
        transform: scale(.95);
      }
    }

    .product-img {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .product-img img {
      width: 100%;
      max-width: 360px;
      border-radius: 50%;
      box-shadow: 0 20px 40px rgba(237, 171, 3, 0.4);
      animation: float 4s ease-in-out infinite;
      border: 7px solid #dfac60;
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0px);
      }

      50% {
        transform: translateY(-12px);
      }
    }

    .product-content h1 {
      font-family: 'Playfair Display', serif;
      font-size: 42px;
      font-weight: 700;
      color: var(--cafe-dark);
      margin-bottom: 12px;
      padding-right: 30px;
      line-height: 1.2;
    }

    /* .rating {
      margin-bottom: 15px;
      color: var(--cafe-primary);
      font-size: 1.1rem;
    }

    .rating i {
      margin-right: 4px;
    } */

    .product-content p {
      color: var(--text-muted);
      line-height: 1.8;
      margin-bottom: 20px;
      font-size: 1.05rem;
    }

    .price {
      font-size: 34px;
      color: var(--cafe-dark);
      font-weight: 700;
      margin-bottom: 25px;
    }

    .section-label {
      color: var(--cafe-primary);
      font-weight: 600;
      font-size: 0.95rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 10px;
      display: block;
    }

    .qty-container {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 25px;
    }

    .qty-btn {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      border: 2px solid var(--cafe-primary);
      font-size: 22px;
      background: transparent;
      color: var(--cafe-primary);
      cursor: pointer;
      transition: .3s;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .qty-btn:hover {
      background-color: #b05806;
      color: white;
      transform: scale(1.08);
    }

    #qty {
      width: 70px;
      height: 42px;
      border: 2px solid rgba(78, 35, 4, 0.5);
      border-radius: 10px;
      text-align: center;
      font-weight: 600;
      font-size: 18px;
      color: var(--text-dark);
      background: #FFFFFF;
    }

    .total {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 25px;
      color: var(--cafe-dark);
    }

    .payment-options {
      display: flex;
      gap: 15px;
      margin-bottom: 30px;
    }

    .pay-method {
      flex: 1;
      padding: 14px;
      border-radius: 12px;
      background: #ffffff;
      border: 2px solid rgba(166, 123, 91, 0.2);
      color: var(--text-muted);
      cursor: pointer;
      transition: .3s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      font-weight: 500;
    }

    .pay-method.active {
      /* background: rgba(224, 128, 55, 0.1); */
      background-color: #eed4a2;
      border-color: var(--cafe-primary);
      color: var(--cafe-dark);
      font-weight: 600;
    }

    .pay-method:hover {
      transform: translateY(-3px);
      /* background-color: #dea676; */
      box-shadow: 0 5px 15px rgba(232, 147, 82, 0.15);
    }

    .buttons {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }

    .btn-custom {
      border: none;
      border-radius: 50px;
      padding: 14px 30px;
      cursor: pointer;
      transition: .4s;
      font-size: 1rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .order-btn {
      background: linear-gradient(135deg, #a95103 0%, #5a2a02 100%);
      color: #ffffff;
      box-shadow: 0 8px 20px rgba(169, 81, 3, 0.25);
    }

    .order-btn:hover {
      background: linear-gradient(135deg, #e67e22 0%, #cc6607 100%);
      transform: translateY(-4px);
      box-shadow: 0 12px 25px rgba(204, 102, 7, 0.35);
    }

    .fav-btn {
      background: transparent;
      color: #9e9e9e; /* Neutral gray — red ONLY set by .is-favorited class via JS */
      border: 2px solid rgba(158, 158, 158, 0.3);
    }

    .fav-btn.is-favorited {
      background: #dc3545;
      color: white;
      border-color: #dc3545;
    }

    /* Legacy alias */
    .fav-btn.active {
      background: #dc3545;
      color: white;
      border-color: #dc3545;
    }

    .fav-btn:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 20px rgba(220, 53, 69, 0.2);
    }

    .toast-msg {
      position: fixed;
      right: 30px;
      bottom: 30px;
      background: var(--cafe-dark);
      color: #FFFFFF;
      padding: 15px 25px;
      border-radius: 12px;
      font-weight: 500;
      opacity: 0;
      transform: translateY(30px);
      transition: .4s;
      z-index: 999;
      box-shadow: 0 10px 30px rgba(44, 30, 22, 0.3);
      border-left: 4px solid var(--cafe-primary);
    }

    .toast-msg.show {
      opacity: 1;
      transform: translateY(0);
    }

    @media(max-width:768px) {
      .product-card {
        grid-template-columns: 1fr;
        text-align: center;
        padding: 40px 25px 25px 25px;
      }

      .close-btn {
        top: 15px;
        right: 15px;
      }

      .payment-options,
      .buttons,
      .qty-container {
        justify-content: center;
      }

      .buttons {
        flex-direction: column;
      }

      .btn-custom {
        justify-content: center;
      }

      .product-content h1 {
        font-size: 32px;
        padding-right: 0;
      }
    }
  </style>
</head>

<body>

  <?php
  if (isset($_GET['btn']) && $_GET['btn'] === 'order') {
    $product_id = $_GET['id'];
    $product = single_row_details('products', $product_id);
    $category_id = $product['category_id'];
  }
  ?>


  <div class="product-card" id="productCard">
    <button class="close-btn" title="Close Panel">
      <a href="index.php"><i class="fa-solid fa-xmark"></i></a>
    </button>

    <div class="product-img">
      <img src="upload/<?php echo $product['image'] ?>" style="height: 380px; width:500px" alt="Coffee">
    </div>

    <div class="product-content">
      <h1><?php echo $product['name']; ?></h1>

      <!-- <div class="rating">
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
        <i class="fa-regular fa-star"></i>
      </div> -->

      <p style="text-align: justify;">
        <?php echo $product['description']; ?>
      </p>

      <div class="price" id="amt">₹<?php echo $product['price'] ?></div>

      <span class="section-label">Select Quantity</span>

      <div class="qty-container">
        <button class="qty-btn" onclick="changeQty(-1)">−</button>
        <input type="text" id="qty" value="1" readonly>
        <button class="qty-btn" onclick="changeQty(1)">+</button>
      </div>

      <div class="total">
        Total: ₹ <span id="total-amt"><?php echo $product['price'] ?></span>
      </div>

      <span class="section-label">Select Payment Method</span>

      <div class="payment-options">
        <div class="pay-method active" id="cashMethod" onclick="selectPayment('cash')">
          <i class="fa-solid fa-money-bill-wave"></i> Cash
        </div>
        <div class="pay-method" id="upiMethod" onclick="selectPayment('upi')">
          <i class="fa-solid fa-qrcode"></i> Net Banking
        </div>
      </div>

      <div class="buttons">
        <button class="btn-custom order-btn" onclick="handleOrder()">
          <i class="fa-solid fa-cart-shopping"></i> Order Now
        </button>

        <?php
        $is_logged_in = isset($_SESSION['id']);
        $is_favorited = $is_logged_in ? accesss_favorite_item($product['id']) : false;
        if (!$is_logged_in) {
            $fav_action = 'guest';
        } elseif ($is_favorited) {
            $fav_action = 'remove';
        } else {
            $fav_action = 'add';
        }
        ?>
        <button class="btn-custom fav-btn <?php echo $is_favorited ? 'is-favorited' : ''; ?>"
          id="favBtn"
          data-action="<?php echo $fav_action; ?>"
          data-product-id="<?php echo $product['id']; ?>">
          <i class="<?php echo $is_favorited ? 'fa-solid' : 'fa-regular'; ?> fa-heart"></i> Favorite
        </button>
      </div>
    </div>
  </div>

  <script>
    let basePrice = <?php echo $product['price'] ?>;
    let qty = 1;
    let paymentMethod = "cash";

    // CLOSE CARD FUNCTION
    function closeCard() {
      const card = document.getElementById("productCard");
      card.style.animation = "fadeOut 0.5s ease forwards";
      showToast("ℹ️ Product view closed.");
      setTimeout(() => {
        card.remove();
      }, 500);
    }

    // UPDATE TOTAL
    function updateTotal() {
      let total = Number((basePrice * qty).toFixed(2));
      document.getElementById("total-amt").innerText = total;
    }

    // CHANGE QTY
    function changeQty(value) {
      qty = Math.max(1, qty + value);
      document.getElementById("qty").value = qty;
      updateTotal();
    }

    // SELECT PAYMENT
    function selectPayment(method) {
      paymentMethod = method;
      document.getElementById("cashMethod").classList.remove("active");
      document.getElementById("upiMethod").classList.remove("active");

      if (method === "cash") {
        document.getElementById("cashMethod").classList.add("active");
      } else {
        document.getElementById("upiMethod").classList.add("active");
      }
    }

    // ORDER
    function handleOrder() {
      let quantity = document.getElementById('qty').value;
      let totalAmt = basePrice * qty;

      // CASH PAYMENT
      if (paymentMethod === "cash") {

        showToast("☕ Order Placed Successfully!");

        setTimeout(() => {

          window.location.href =
            `Ui-All-Function.php?category_id=<?php echo $category_id; ?>` +
            `&product_id=<?php echo $product_id; ?>` +
            `&qty=${quantity}` +
            `&price=${basePrice}` +
            `&total_amt=${totalAmt}` +
            `&payment_method=Cash` +
            `&type=payment`;

        }, 1500);
        return;
      }

      // RAZORPAY PAYMENT
      var options = {
        key: "rzp_test_TGe16Sk8SxvzUx",
        amount: totalAmt * 100,
        currency: "INR",
        name: "Delicious Cafe",
        description: "Coffee Payment",

        image: "https://similarpng.com/_next/image?url=https%3A%2F%2Fimage.similarpng.com%2Ffile%2Fsimilarpng%2Fvery-thumbnail%2F2020%2F11%2FCoffee-logo-design-on-transparent-background-PNG.png&w=1080&q=75",

        handler: function(response) {

          showToast("✅ Payment Successful!");

          setTimeout(() => {

            window.location.href =
              `Ui-All-Function.php?category_id=<?php echo $category_id; ?>` +
              `&product_id=<?php echo $product_id; ?>` +
              `&qty=${quantity}` +
              `&price=${basePrice}` +
              `&total_amt=${totalAmt}` +
              `&payment_method=Net Banking` +
              `&payment_id=${response.razorpay_payment_id}` +
              `&type=payment`;

          }, 1500);
        },

        prefill: {
          name: "Santu Sau",
          email: "customer@example.com",
          contact: "7797913726"
        },

        theme: {
          color: "#e79006"
        },

        method: {
          upi: true,
          card: true,
          netbanking: true,
          wallet: true,
          paylater: true
        }
      };

      var rzp = new Razorpay(options);
      rzp.open();
    }

    // FAVORITE — handled via data-action attribute and AJAX toggle
    (function() {
      const favBtn = document.getElementById('favBtn');
      if (!favBtn) return;

      favBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const action = this.dataset.action;
        const productId = this.dataset.productId;

        if (this.dataset.busy === '1') return;

        if (action === 'guest' || !productId) {
          // Not logged in — enforce empty state, never show red
          this.classList.remove('is-favorited', 'active');
          const icon = this.querySelector('i');
          if (icon) { icon.classList.remove('fa-solid'); icon.classList.add('fa-regular'); }
          if (typeof showGuestAlert === 'function') {
            showGuestAlert('Add to Favorite');
          } else {
            showToast('⚠️ Please login to add to favorites!');
            setTimeout(() => { window.location.href = 'Login_form.php'; }, 1000);
          }
          return;
        }

        const self = this;
        self.dataset.busy = '1';
        self.style.pointerEvents = 'none';

        fetch('Ui-All-Function.php?btn=favorite_btn&pid=' + encodeURIComponent(productId) + '&ajax=1', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            self.dataset.busy = '0';
            self.style.pointerEvents = 'auto';

            const icon = self.querySelector('i');
            if (data.status === 'added') {
                self.classList.add('is-favorited');
                self.dataset.action = 'remove';
                if (icon) {
                    icon.classList.remove('fa-regular');
                    icon.classList.add('fa-solid');
                }
                showToast("❤️ Added to Favorites!");
            } else if (data.status === 'removed') {
                self.classList.remove('is-favorited', 'active');
                self.dataset.action = 'add';
                if (icon) {
                    icon.classList.remove('fa-solid');
                    icon.classList.add('fa-regular');
                }
                showToast("💔 Removed from Favorites!");
            } else if (data.status === 'login_required') {
                self.classList.remove('is-favorited', 'active');
                self.dataset.action = 'guest';
                if (icon) {
                    icon.classList.remove('fa-solid');
                    icon.classList.add('fa-regular');
                }
                if (typeof showGuestAlert === 'function') {
                    showGuestAlert('Add to Favorite');
                } else {
                    showToast('⚠️ Please login first!');
                }
            } else {
                showToast("❌ Error updating favorite.");
            }
        })
        .catch(err => {
            self.dataset.busy = '0';
            self.style.pointerEvents = 'auto';
            showToast("❌ Network error.");
        });
      });
    })();

    // TOAST
    function showToast(msg) {
      const old = document.querySelector(".toast-msg");
      if (old) old.remove();

      const toast = document.createElement("div");
      toast.className = "toast-msg";
      toast.innerText = msg;
      document.body.appendChild(toast);

      setTimeout(() => {
        toast.classList.add("show");
      }, 50);

      setTimeout(() => {
        toast.classList.remove("show");
        setTimeout(() => {
          toast.remove();
        }, 300);
      }, 2500);
    }
  </script>

</body>

</html>