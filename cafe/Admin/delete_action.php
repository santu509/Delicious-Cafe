<?php
include_once('admin_auth.php');
include_once('All-Function.php');
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
// include_once('All-Function.php');

// if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['btn'] == 'user') {
//     $id = $_GET['id'];
//     $call = delete_data('customers', $id);
//     if ($call) {
//         echo "<script>alert('User Delete Successful.');window.location.href='user_list.php';</script>";
//     } else {
//         echo "<script>alert('User Delete Unsuccessful.');window.location.href='user_list.php';</script>";
//     }
// }
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['btn'] == 'product') {
    $id = $_GET['id'];
    $call = delete_data('products', $id);
    if ($call) {
        $_SESSION['status'] = true;
        $_SESSION['msg'] = "Item Deleted Successfully.";
        echo "<script>window.location.href='product-list.php';</script>";
    } else {
        $_SESSION['status'] = false;
        $_SESSION['msg'] = "Item Delete Action Failde!Please Try Agai.";
        echo "<script>alert('You are Unsuccessful For Delete The Product.');window.location.href='product-list.php';</script>";
    }
}
