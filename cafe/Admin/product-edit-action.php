<?php
include_once('admin_auth.php');
include_once('All-Function.php');
$pid = $_POST['id'];
$pcategory = $_POST['category'];
$pname = $_POST['name'];
$pdescription = $_POST['description'];
$pprice = $_POST['price'];
$pstatus = $_POST['status'];

$olddata = single_row_details('products', $pid);
$oldimage = $olddata['image'];

$new_image = $_FILES['image']['name'];
if (!empty($new_image)) {
    if (!empty($oldimage)) {
        if (!empty($oldimage)) {
            unlink("../upload/$oldimage");
        }
        $photo_temp_name = $_FILES['image']['tmp_name'];
        $photo_store_loc = "../upload/" . $new_image;
        move_uploaded_file($photo_temp_name, $photo_store_loc);
    }
} else {
    $new_image = $oldimage;
}


$run = edit_product('products', $pid, $pcategory, $pname, $pdescription, $pprice, $new_image, $pstatus);
if ($run) {
    $_SESSION['status'] = true;
    $_SESSION['msg'] = 'Item Edit Successfully.';
    echo "<script>window.location.href='product-list.php'</script>";
} else {
    $_SESSION['status'] = false;
    $_SESSION['msg'] = 'Item Edit Failed!Please Try Again.';
    echo "<script>window.location.href='product-list.php'</script>";
}
