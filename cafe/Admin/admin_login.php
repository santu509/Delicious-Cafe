<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../connection.php';
global $connect;

if (isset($_POST['btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "select * from admin where '$email'=email_id and '$password'=password";
    $run = mysqli_query($connect, $sql);
    if (mysqli_num_rows($run)) {
        $data = mysqli_fetch_assoc($run);
        // print_r($data);

        $_SESSION['admin_name'] = $data['name'];
        $_SESSION['admin_image'] = $data['image'];
        header('location:banner-revineu.php');
    } else {
        echo "<script>
    alert('Please Fill The Right Information');
    window.location.href='index.php';
</script>";
        exit;
    }
}
