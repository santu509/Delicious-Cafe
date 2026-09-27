<?php
include "connection.php";
include_once("Ui-All-Function.php");
global $connect;


if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['signin_btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sqlquery = "select * from customers where email_id='$email'";
    $runquery = mysqli_query($connect, $sqlquery);


    if (mysqli_num_rows($runquery)) {
        $data = mysqli_fetch_assoc($runquery);
        if ($data['password'] != $password) {
            showCafeAlert('Invalid Password', 'The password you entered is incorrect. Please try again.', 'error', 'Login_form.php');
        } else {
            session_start();
            $_SESSION['id'] = $data['id'];
            $_SESSION['eid'] = $data['email_id'];
            $_SESSION['username'] = $data['name'];
            $_SESSION['photo'] = $data['profile'];
            header('location:index.php');
        }
    } else {
        showCafeAlert('Account Not Found', 'No registered account found with this email address. Please check and try again.', 'error', 'Login_form.php');
    }
}
