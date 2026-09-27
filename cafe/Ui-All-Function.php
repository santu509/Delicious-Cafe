<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once('connection.php');
include_once("mail.php");

/**
 * Universal Custom Stylish SweetAlert helper for PHP backend
 */
function showCafeAlert($title, $message, $icon = 'info', $redirectUrl = null)
{
    $iconColor = '#c18c5d';
    if ($icon === 'success') $iconColor = '#2a9d8f';
    else if ($icon === 'error') $iconColor = '#e63946';
    else if ($icon === 'warning') $iconColor = '#e79006';

    $redirectUrlJs = $redirectUrl ? addslashes($redirectUrl) : '';
    $autoTimer = ($icon === 'success') ? '3000' : 'null';
    $progressBar = ($icon === 'success') ? 'true' : 'false';

    echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>" . htmlspecialchars($title) . " - Delicious Cafe</title>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/animate.css@4/animate.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@400;500;600&display=swap'>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <style>
        body {
            background-color: #faf8f5;
            font-family: 'DM Sans', sans-serif;
            margin: 0;
            padding: 0;
        }
        .cafe-alert-popup {
            background: #ffffff !important;
            border-radius: 24px !important;
            padding: 30px 24px 26px !important;
            border: 1px solid rgba(193, 140, 93, 0.22) !important;
            box-shadow: 0 20px 60px rgba(54, 34, 28, 0.2) !important;
            font-family: 'DM Sans', sans-serif !important;
            max-width: 420px !important;
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
            margin-top: 15px !important;
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let targetUrl = '" . $redirectUrlJs . "';
            let hasRedirected = false;

            function doRedirect() {
                if (hasRedirected) return;
                hasRedirected = true;
                if (targetUrl && targetUrl.length > 0) {
                    window.location.replace(targetUrl);
                } else {
                    history.back();
                }
            }

            Swal.fire({
                title: '" . addslashes($title) . "',
                html: '<p class=\"text-muted mb-0\" style=\"color:#6c757d; font-size:0.95rem; line-height:1.5;\">" . addslashes($message) . "</p>',
                icon: '" . addslashes($icon) . "',
                iconColor: '{$iconColor}',
                confirmButtonText: 'Continue',
                buttonsStyling: false,
                backdrop: 'rgba(44, 24, 16, 0.45)',
                timer: {$autoTimer},
                timerProgressBar: {$progressBar},
                customClass: {
                    popup: 'cafe-alert-popup animate__animated animate__zoomIn animate__faster',
                    title: 'cafe-alert-title',
                    confirmButton: 'cafe-alert-btn'
                },
                willClose: () => {
                    doRedirect();
                }
            }).then(() => {
                doRedirect();
            });

            // Ultimate fallback to ensure redirect happens if Swal doesn't fire
            " . ($redirectUrl ? "setTimeout(doRedirect, " . ($icon === 'success' ? '3200' : '10000') . ");" : "") . "
        });
    </script>
</body>
</html>";
    exit();
}

function AllDetails($table_name)
{
    global $connect;
    $sql = "SELECT * FROM {$table_name} where status=1";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        if (mysqli_num_rows($run)) {
            return mysqli_fetch_all($run, MYSQLI_ASSOC);
        } else {
            return false;
        }
    } else {
        return false;
    }
}


function Allproducts($table_name)
{
    global $connect;
    $sql = "SELECT * FROM {$table_name} WHERE is_available=1";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        if (mysqli_num_rows($run)) {
            return mysqli_fetch_all($run, MYSQLI_ASSOC);
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function products($table_name)
{
    global $connect;
    $sql = "SELECT * FROM {$table_name} WHERE is_available=1 LIMIT 8";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        if (mysqli_num_rows($run)) {
            return mysqli_fetch_all($run, MYSQLI_ASSOC);
        } else {
            return false;
        }
    } else {
        return false;
    }
}



function userdetails($id)
{
    global $connect;
    $sql = "SELECT * FROM customers WHERE id='$id'";
    $run = mysqli_query($connect, $sql);
    if (mysqli_num_rows($run)) {
        return mysqli_fetch_assoc($run);
    } else {
        return false;
    }
}

// access the single item or row for any table
function single_row_details($table_name, $id)
{
    global $connect;
    $sql = "SELECT * FROM {$table_name} WHERE id={$id}";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        return mysqli_fetch_assoc($run);
    } else {
        return false;
    }
}

// feedback section all functionality
// feedback form submit
if (isset($_POST["feedback-btn"])) {
    if (!isset($_SESSION['id'])) {
        showCafeAlert('Sign In Required', 'Please finish your registration and log in before giving feedback.', 'warning', 'Login_form.php');
    } else {

        $c_id = $_SESSION['id'];
        $rating = $_POST['star'];
        $review = $_POST['review'];
        feedback_insert($c_id, $rating, $review);
        header("location:index.php");
    }
}
function feedback_insert($id, $rating, $review)
{
    global $connect;
    $sql = "INSERT INTO feedback (customers_id,rating,review)VALUES('$id','$rating','$review')";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        return true;
    } else {
        return false;
    }
}
// feedback form submit end


// feedback edit functionality start

if (isset($_POST["feedback_edit_btn"])) {
    if (!isset($_SESSION['id'])) {
        showCafeAlert('Sign In Required', 'Please finish your registration and log in before giving feedback.', 'warning', 'Login_form.php');
    } else {
        $c_id = $_SESSION['id'];
        $rating = $_POST['star'];
        $review = $_POST['review'];
        feedback_update($c_id, $rating, $review);
        header("location:index.php");
    }
}
function feedback_update($c_id, $rating, $review)
{
    global $connect;
    $sql = "UPDATE feedback SET rating='$rating',review='$review' WHERE customers_id='$c_id'";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        return true;
    } else {
        return false;
    }
}
// feedback edit functionality end

function Allfeedback()
{
    global $connect;
    $sql = "SELECT * FROM feedback";
    $run = mysqli_query($connect, $sql);
    if (mysqli_num_rows($run)) {
        return mysqli_fetch_all($run, MYSQLI_ASSOC);
    } else {
        return false;
    }
}

function single_feedback($table_name, $c_id)
{
    global $connect;
    $sql = "SELECT * FROM {$table_name} WHERE customers_id={$c_id}";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        return mysqli_fetch_assoc($run);
    } else {
        return false;
    }
}


// contact us form action start


// if (isset($_POST['contact-btn'])) {
//     global $connect;

//     if (!isset($_SESSION['id'])) {
//         echo "<script>alert('At First Finished Your Registration & Login After That Send Message.');window.location.href='Login_form.php'</script>";
//         exit();
//     }
//     $customer_id = (int)$_SESSION['id'];
//     $name = $_SESSION['username'];
//     $email = $_SESSION['eid'];

//     $msg_subject = mysqli_real_escape_string($connect, $_POST['subject']);
//     $message = mysqli_real_escape_string($connect, $_POST['message']);
//     $sql = "INSERT INTO contactus
//     (customer_id, cname, cemail, subject,message) VALUES ($customer_id,'$name','$email','$msg_subject','$message')";

//     $run = mysqli_query($connect, $sql);

//     if ($run) {
//         echo "<script>alert('Message send successfully');window.location.href='index.php'</script>";
//         exit();
//     } else {
//         die(mysqli_error($connect));
//     }
// }

// contact us form action end





// favorite option all fuctionality start
if ((isset($_GET['btn']) && $_GET['btn'] == 'favorite_btn') || (isset($_POST['btn']) && $_POST['btn'] == 'favorite_btn')) {
    global $connect;

    $is_ajax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') 
               || isset($_GET['ajax']) 
               || isset($_POST['ajax'])
               || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);

    if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
        if ($is_ajax) {
            if (ob_get_length()) ob_clean();
            if (!headers_sent()) header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'status' => 'login_required',
                'message' => 'Please login to add items to your wishlist.',
                'total_count' => 0
            ]);
            exit();
        } else {
            showCafeAlert('Sign In Required', 'Please log in first to add items to your wishlist.', 'warning', 'Login_form.php');
        }
    }

    $customer_id = (int)$_SESSION['id'];
    $product_id = isset($_POST['pid']) ? (int)$_POST['pid'] : (isset($_GET['pid']) ? (int)$_GET['pid'] : 0);

    if ($product_id <= 0) {
        if ($is_ajax) {
            if (ob_get_length()) ob_clean();
            if (!headers_sent()) header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid product ID.',
                'total_count' => total_favorite_item()
            ]);
            exit();
        } else {
            header('location:index.php');
            exit();
        }
    }

    try {
        // Check whether customer + product already exists in wishlist
        $check_stmt = mysqli_prepare($connect, "SELECT wishlist_id FROM wishlist WHERE customer_id = ? AND product_id = ?");
        mysqli_stmt_bind_param($check_stmt, "ii", $customer_id, $product_id);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);
        $exists = mysqli_stmt_num_rows($check_stmt) > 0;
        mysqli_stmt_close($check_stmt);

        if ($exists) {
            // Already exists -> DELETE (TOGGLE OFF)
            $del_stmt = mysqli_prepare($connect, "DELETE FROM wishlist WHERE customer_id = ? AND product_id = ?");
            mysqli_stmt_bind_param($del_stmt, "ii", $customer_id, $product_id);
            mysqli_stmt_execute($del_stmt);
            mysqli_stmt_close($del_stmt);

            $new_count = total_favorite_item();

            if ($is_ajax) {
                if (ob_get_length()) ob_clean();
                if (!headers_sent()) header('Content-Type: application/json; charset=utf-8');
                echo json_encode([
                    'status' => 'removed',
                    'message' => 'Item removed from wishlist',
                    'product_id' => $product_id,
                    'total_count' => $new_count
                ]);
                exit();
            } else {
                $redirect = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
                header("location:" . $redirect);
                exit();
            }
        } else {
            // Does not exist -> INSERT (TOGGLE ON)
            $ins_stmt = mysqli_prepare($connect, "INSERT INTO wishlist (customer_id, product_id) VALUES (?, ?)");
            mysqli_stmt_bind_param($ins_stmt, "ii", $customer_id, $product_id);
            mysqli_stmt_execute($ins_stmt);
            mysqli_stmt_close($ins_stmt);

            $new_count = total_favorite_item();
            $prod_info = single_row_details('products', $product_id);

            if ($is_ajax) {
                if (ob_get_length()) ob_clean();
                if (!headers_sent()) header('Content-Type: application/json; charset=utf-8');
                echo json_encode([
                    'status' => 'added',
                    'message' => 'Item added to wishlist',
                    'product_id' => $product_id,
                    'total_count' => $new_count,
                    'product' => $prod_info ? [
                        'id' => (int)$prod_info['id'],
                        'name' => $prod_info['name'],
                        'price' => $prod_info['price'],
                        'image' => $prod_info['image']
                    ] : null
                ]);
                exit();
            } else {
                $redirect = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
                header("location:" . $redirect);
                exit();
            }
        }
    } catch (mysqli_sql_exception $e) {
        $new_count = total_favorite_item();
        if ($is_ajax) {
            if (ob_get_length()) ob_clean();
            if (!headers_sent()) header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'status' => 'error',
                'message' => 'Database operation failed.',
                'total_count' => $new_count
            ]);
            exit();
        } else {
            $redirect = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
            header("location:" . $redirect);
            exit();
        }
    }
}


function accesss_favorite_item($pid)
{
    global $connect;
    if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
        return false;
    }
    $c_id = (int)$_SESSION['id'];
    $pid = (int)$pid;
    $stmt = mysqli_prepare($connect, "SELECT wishlist_id FROM wishlist WHERE customer_id = ? AND product_id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $c_id, $pid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $exists = mysqli_stmt_num_rows($stmt) > 0;
        mysqli_stmt_close($stmt);
        return $exists;
    }
    return false;
}


// select those item that only one customer is add to his favorite list

function all_favorite_item()
{
    global $connect;
    if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
        return [];
    }
    $c_id = (int)$_SESSION['id'];
    $stmt = mysqli_prepare($connect, "SELECT * FROM wishlist WHERE customer_id = ? ORDER BY created_at DESC");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $c_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data = $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
        mysqli_stmt_close($stmt);
        return $data;
    }
    return [];
}

function total_favorite_item()
{
    global $connect;

    if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
        return 0;
    }

    $c_id = (int)$_SESSION['id'];

    $stmt = mysqli_prepare($connect, "SELECT COUNT(*) AS total FROM wishlist WHERE customer_id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $c_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result && $row = mysqli_fetch_assoc($result)) {
            $total = (int)$row['total'];
            mysqli_stmt_close($stmt);
            return $total;
        }
        mysqli_stmt_close($stmt);
    }

    return 0;
}



// remove icon from wishlist start
if ((isset($_GET['btn']) && $_GET['btn'] == 'remove') || (isset($_POST['btn']) && $_POST['btn'] == 'remove')) {
    global $connect;

    $is_ajax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') 
               || isset($_GET['ajax']) 
               || isset($_POST['ajax'])
               || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);

    if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
        if ($is_ajax) {
            if (ob_get_length()) ob_clean();
            if (!headers_sent()) header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'status' => 'login_required',
                'message' => 'Please login to manage your wishlist.',
                'total_count' => 0
            ]);
            exit();
        } else {
            header("location:Login_form.php");
            exit();
        }
    }

    $customer_id = (int)$_SESSION['id'];
    $product_id = isset($_POST['pid']) ? (int)$_POST['pid'] : (isset($_GET['pid']) ? (int)$_GET['pid'] : 0);

    if ($product_id > 0) {
        try {
            $del_stmt = mysqli_prepare($connect, "DELETE FROM wishlist WHERE customer_id = ? AND product_id = ?");
            if ($del_stmt) {
                mysqli_stmt_bind_param($del_stmt, "ii", $customer_id, $product_id);
                mysqli_stmt_execute($del_stmt);
                mysqli_stmt_close($del_stmt);
            }
        } catch (mysqli_sql_exception $e) {
            // Handled gracefully
        }
    }

    $new_count = total_favorite_item();

    if ($is_ajax) {
        if (ob_get_length()) ob_clean();
        if (!headers_sent()) header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'status' => 'removed',
            'message' => 'Item removed from wishlist',
            'product_id' => $product_id,
            'total_count' => $new_count
        ]);
        exit();
    } else {
        $redirect = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
        header("location:" . $redirect);
        exit();
    }
}

// remove icon from wishlist end

// favorite option all fuctionality end



// payment and order placed section insert query start

if (isset($_GET['type']) and $_GET['type'] == 'payment') {
    global $connect;
    $customer_id = $_SESSION['id'] ?? '';
    $customer_name = $_SESSION['username'] ?? '';
    $category_id = $_GET['category_id'] ?? '';
    $product_id = $_GET['product_id'] ?? '';
    $quantity = $_GET['qty'] ?? '';
    $price = $_GET['price'] ?? '';
    $total_amount = $_GET['total_amt'] ?? '';
    $payment_method = $_GET['payment_method'] ?? '';
    $payment_id = isset($_GET['payment_id'])
        ? $_GET['payment_id']
        : '';

    $sql = "INSERT INTO orders
(customer_id,customer_name,category_id,product_id,quantity,price,total_price,payment_method,transaction_id)
VALUES
('$customer_id','$customer_name','$category_id','$product_id','$quantity','$price','$total_amount','$payment_method','$payment_id')";

    $run = mysqli_query($connect, $sql);

    if ($run) {

        $customerEmail = $_SESSION['eid'];

        $productInfo = single_row_details(
            'products', 
            $product_id
        );

        $productName = $productInfo['name'];

        orderMail(
            $customer_name,
            $customerEmail,
            $productName,
            $quantity,
            $price,
            $total_amount,
            $payment_method
        );

        header("location:history.php");
        exit();
    } else {
        return false;
    }
}


// payment and order placed section insert query end


// all orders history for user start

function Allorders()
{
    global $connect;
    $customer_id = $_SESSION['id'] ?? '';
    $sql = "select * from orders where customer_id='$customer_id' ORDER BY created_at DESC";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        return mysqli_fetch_all($run, MYSQLI_ASSOC);
    } else {
        return false;
    }
}



// all booking history for user start

function Allbooking()
{
    global $connect;
    $customer_id = $_SESSION['id'] ?? '';
    
    
    $sql = "SELECT * FROM tablebook WHERE customer_id='$customer_id' ORDER BY created_at DESC";
    $run = mysqli_query($connect, $sql);
    
    if ($run && mysqli_num_rows($run) > 0) {
        return mysqli_fetch_all($run, MYSQLI_ASSOC);
    } else {
        return []; 
    }
}




// product details
function productdetails($product_id)
{
    global $connect;
    $sql = "select name,description,image from products where id='$product_id'";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        return mysqli_fetch_assoc($run);
    } else {
        return false;
    }
}

// all orders history for user end




// faq all functionality start
function allfaq()
{
    global $connect;
    $sql = "SELECT * FROM faq";
    $run = mysqli_query($connect, $sql);
    if (mysqli_num_rows($run) > 0) {
        return mysqli_fetch_all($run, MYSQLI_ASSOC);
    } else {
        return false;
    }
}

// faq all functionality end
