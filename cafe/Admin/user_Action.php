<?php
include_once('admin_auth.php');
include_once('All-Function.php');

// add user in user_list function

if (isset($_POST['customer-add-btn'])) {
    $customer_name = $_POST['name'];
    $customer_email = $_POST['email'];
    $customer_password = $_POST['password'];
    $customer_pic = $_FILES['profileimg'];
    $addcustomer = AddUser($customer_name, $customer_email, $customer_password, $customer_pic);
    if ($addcustomer) {
        $_SESSION['status'] = true;
        $_SESSION['msg'] = 'New Customer Add Successfully.';
        header("Location:user_list.php");
        exit();
    } else {
        $_SESSION['status'] = false;
        $_SESSION['msg'] = 'New Customer Add Failed.';
        header("Location:user_list.php");
        exit();
    }
}

function AddUser($customer_name, $customer_email, $customer_password, $customer_photoname)
{
    global $connect;
    $customer_image = $customer_photoname['name'];
    $image_temp_name =  $customer_photoname['tmp_name'];
    $photo_store_loc = "../upload/" . $customer_image;

    $sql = "insert into customers(name,email_id,password,profile)values('$customer_name','$customer_email','$customer_password','$customer_image')";
    $email_check = "select email_id from customers where email_id='$customer_email'";
    $run = mysqli_query($connect, $email_check);
    if (mysqli_num_rows($run) > 0) {
        echo "<script>
alert('Email already exists! Use another email');
window.location.href='user_list.php';
</script>";
        exit();
    } else {
        move_uploaded_file($image_temp_name, $photo_store_loc);
        $run = mysqli_query($connect, $sql);
        if ($run) {
            return true;
        } else {
            return false;
        }
    }
}
