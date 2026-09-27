<?php
include_once('admin_auth.php');
include_once('../connection.php');

function TotalItemsEachCategory($tableName, $cid)
{
    global $connect;
    $sql = "SELECT * FROM $tableName WHERE category_id={$cid}";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        $totalrows = mysqli_num_rows($run);
        return $totalrows;
    } else {
        return false;
    }
}

function addcategory($c_name, $c_desc)
{
    global $connect;
    $sql = "INSERT INTO categories (name,description) VALUES ('$c_name','$c_desc')";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST['add-btn'])) {
    $category_name = $_POST['category_name'];
    $category_desc = $_POST['category_description'];
    $AddCategoryFunc = addcategory($category_name, $category_desc);
    if ($AddCategoryFunc) {
        $_SESSION['status'] = true;
        $_SESSION['msg'] = 'New Category Add Successfully.';
        header("Location: category.php");
        exit();
    } else {
        $_SESSION['status'] = false;
        $_SESSION['msg'] = 'New Category Add Failed.';
        header("Location: category.php");
        exit();
    }
}


function delete_category($table_name, $id)
{
    global $connect;
    $sql = "DELETE FROM {$table_name} WHERE id={$id}";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['btn']) && $_GET['btn'] == 'category') {
    $c_Id = $_GET['id'];
    $delete = delete_category('categories', $c_Id);
    if ($delete) {
        $_SESSION['status'] = true;
        $_SESSION['msg'] = 'Delete Category Successfully.';
    } else {
        $_SESSION['status'] = false;
        $_SESSION['msg'] = 'Category Delete Operation Failed.';
    }
    header("Location: category.php");
    exit();
}


function single_category_details($table_name, $id)
{
    global $connect;
    $sql = "SELECT * FROM  {$table_name} WHERE id={$id}";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        return mysqli_fetch_assoc($run);
    } else {
        return false;
    }
}



function editcategory($c_id, $c_name, $c_status, $c_desc)
{
    global $connect;
    $sql = "UPDATE categories SET name='$c_name',status='$c_status',description='$c_desc' WHERE id=$c_id";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST['edit-btn'])) {
    $category_Id = $_POST['c_id'];
    $category_name = $_POST['category_name'];
    $category_status = $_POST['category_status'];
    $category_desc = $_POST['category_description'];
    $EditCategoryFunc = editcategory($category_Id, $category_name, $category_status, $category_desc);
    if ($EditCategoryFunc) {
        $_SESSION['status'] = true;
        $_SESSION['msg'] = 'Category Edit Successfully.';
        header("Location: category.php");
        exit();
    } else {
        $_SESSION['status'] = false;
        $_SESSION['msg'] = 'Category Edit Failed.';
        header("Location: category.php");
        exit();
    }
}



// total category
function TotalCategory($table_name)
{
    global $connect;
    $sql = "SELECT * FROM $table_name";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        // $totaldata=mysqli_fetch_all($run);
        $totalRow = mysqli_num_rows($run);
        return $totalRow;
    } else {
        return false;
    }
}

// Active Categories

function ActiveCategory($table_name)
{
    global $connect;
    $sql = "SELECT * FROM $table_name WHERE status=1";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        // $totaldata=mysqli_fetch_all($run);
        $totalRow = mysqli_num_rows($run);
        return $totalRow;
    } else {
        return false;
    }
}


// InActiveCategory
function InActiveCategory($table_name)
{
    global $connect;
    $sql = "SELECT * FROM $table_name WHERE status=0";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        // $totaldata=mysqli_fetch_all($run);
        $totalRow = mysqli_num_rows($run);
        return $totalRow;
    } else {
        return false;
    }
}

// Total Items
function TotalItems($table_name)
{
    global $connect;
    $sql = "SELECT * FROM $table_name";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        // $totaldata=mysqli_fetch_all($run);
        $totalRow = mysqli_num_rows($run);
        return $totalRow;
    } else {
        return false;
    }
}