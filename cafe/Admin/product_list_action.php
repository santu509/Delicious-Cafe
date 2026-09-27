<?php
include_once('admin_auth.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once('../connection.php');

function TotalItems($tableName)
{
    global $connect;
    $sql = "SELECT * FROM $tableName";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        return mysqli_num_rows($run);
    } else {
        return false;
    }
}


function AvailableItems($table_name)
{
    global $connect;
    $sql = "SELECT * FROM $table_name WHERE is_available=1";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        return mysqli_num_rows($run);
    } else {
        return false;
    }
}


function NotAvailableItems($table_name)
{
    global $connect;
    $sql = "SELECT * FROM $table_name WHERE is_available=0";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        $totalRow = mysqli_num_rows($run);
        return $totalRow;
    } else {
        return false;
    }
}


function Allcategory($table_name)
{
    global $connect;
    $sql = "SELECT * FROM $table_name";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        return mysqli_fetch_all($run, MYSQLI_ASSOC);
    } else {
        return false;
    }
}

function SingleCategoryAllItems($table_name, $C_id)
{
    global $connect;
    $sql = "SELECT * FROM $table_name where category_id=$C_id";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        return mysqli_fetch_all($run, MYSQLI_ASSOC);
    } else {
        return false;
    }
}



// if (isset($_GET['select']) && $_GET['select'] == 'category') {

//     $cid = intval($_GET['id']);

//     $sql = "SELECT * FROM products WHERE category_id = $cid";
//     $run = mysqli_query($connect, $sql);

//     if ($run) {
//         $_SESSION['categorywisedata'] = mysqli_fetch_all($run, MYSQLI_ASSOC);
//     } else {
//         $_SESSION['categorywisedata'] = [];
//     }


//     header("Location: product-list.php");
//     exit();
// }

function Allproduct($categoryId)
{
    global $connect;
    if ($categoryId == 'All') {
        $sql = "SELECT * FROM products";
    } else {
        $sql = "SELECT * FROM products where category_id=$categoryId";
    }

    $run = mysqli_query($connect, $sql);
    if ($run) {
        return mysqli_fetch_all($run, MYSQLI_ASSOC);
    } else {
        return false;
    }
}
