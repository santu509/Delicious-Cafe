<?php
include "connection.php";
include_once("Ui-All-Function.php");
global $connect;

if (isset($_POST['signup'])) {
    $name = $_POST['Name'];
    $email = $_POST['email'];
    $password = $_POST['Password'];
    $photo_name = $_FILES['profileimg']['name'];
    $photo_temp_name = $_FILES['profileimg']['tmp_name'];
    $photo_store_loc = "upload/" . $photo_name;
    move_uploaded_file($photo_temp_name, $photo_store_loc);
    $checksql = "SELECT * FROM customers WHERE email_id='$email'";
    $run = mysqli_query($connect, $checksql);
    if (mysqli_num_rows($run) <= 0) {
        $sqlquary = "INSERT INTO customers(name,email_id, password,profile)
            VALUES ('$name', '$email', '$password','$photo_name')";

        if (mysqli_query($connect, $sqlquary)) {
            showCafeAlert('Registration Successful!', 'Welcome to Delicious Cafe, ' . htmlspecialchars($name) . '! Please sign in to access your account.', 'success', 'index.php');
        } else {
            showCafeAlert('Registration Failed', 'Error creating account: ' . mysqli_error($connect), 'error', 'Login_form.php');
        }
    } else {
        showCafeAlert('Email Already Registered', 'An account with this email address already exists. Please sign in or use another email.', 'warning', 'Login_form.php');
    }
}
?>