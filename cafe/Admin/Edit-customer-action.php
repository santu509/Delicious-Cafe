<?php
include_once('admin_auth.php');
include_once('All-Function.php');

if (isset($_POST['submit-btn'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // $photo_name = $_FILES['profileimg']['name'];
    $oldimage = single_row_details('customers', $id);
    $photoname = $_FILES['profileimg']['name'];
    if (!empty($photoname)) {
        if (!empty($oldimage['profile'])) {
            unlink("../upload/$oldimage[profile]");
        }
        $photo_temp_name = $_FILES['profileimg']['tmp_name'];
        $photo_store_loc = "../upload/" . $photoname;
        move_uploaded_file($photo_temp_name, $photo_store_loc);
    } else {
        $photoname = $oldimage['profile'];
    }



    $call = edit_user_profile('customers', $id, $name, $email, $password, $photoname);
    if ($call) {

        $_SESSION['status'] = true;
        $_SESSION['msg'] = 'Edit Customer Data Successfully.';
        header("Location:user_list.php");
        exit();
    } else {
        $_SESSION['status'] = false;
        $_SESSION['msg'] = 'Edit Operation Failed.';
        header("Location:user_list.php");
        exit();
    }
}
