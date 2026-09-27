<?php
include_once('admin_auth.php');
include_once('All-Function.php');
global $connect;
if (isset($_POST['add-btn'])) {
    $product_name = $_POST['name'];
    $product_description = $_POST['description'];
    $product_category = $_POST['category'];
    $product_is_available = $_POST['is_available'];
    $product_price = $_POST['price'];
    $product_img_name = $_FILES['image']['name'];
    $product_img_tmp_name = $_FILES['image']['tmp_name'];
    $upload_location = "../upload/" . $product_img_name;
    move_uploaded_file($product_img_tmp_name, $upload_location);

    $sql = "INSERT INTO products (category_id, name, description, price, image, is_available) 
VALUES 
('$product_category', '$product_name', '$product_description', '$product_price', '$product_img_name', '$product_is_available')";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        $_SESSION['status']=true;
        $_SESSION['msg']='Item Add Successfully.';
        echo "<script>window.location.href='product-list.php'</script>";
        
    }
    else{
        $_SESSION['add_status']=false;
        $_SESSION['msg']='Item Add Action Failed!Please Try Again.';
         echo "<script>window.location.href='product-list.php'</script>";
        
    }
}
