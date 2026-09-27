<?php
include_once('../connection.php');
// global $connect;

function allDetails($table_name)
{
    global $connect;
    $sql = "SELECT * FROM {$table_name} ORDER BY id ASC";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        if (mysqli_num_rows($run)) {
            return mysqli_fetch_all($run, MYSQLI_ASSOC);
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function delete_data($table_name, $id)
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


function edit_user_profile($table_name, $id, $new_name, $email, $password, $photo_name)
{
    global $connect;
    $sql = "UPDATE {$table_name} set name='{$new_name}', email_id='{$email}', password='{$password}',profile='{$photo_name}' where id={$id}";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        return true;
    } else {
        return false;
    }
}

function single_row_details($table_name, $id)
{
    global $connect;
    $sql = "SELECT * FROM {$table_name} WHERE id={$id}";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        return mysqli_fetch_assoc($run);
    } else {
        return false;
    }
}

function edit_product($table_name, $pid, $pcategory_id, $pname, $pdescription, $pprice, $pimage, $pstatus)
{
    global $connect;
    $sql = "UPDATE {$table_name} set category_id='{$pcategory_id}', name='{$pname}', description='{$pdescription}', price='{$pprice}',	image='{$pimage}',is_available='{$pstatus}' where id={$pid}";
    $run = mysqli_query($connect, $sql);
    if ($run) {
        return true;
    } else {
        return false;
    }
}


// pagination function 

function pagination($table, $defaultLimit = 5)
{
    global $connect;

    // Row Limit
    $limit = isset($_GET['limit'])
        ? (int)$_GET['limit']
        : $defaultLimit;

    if ($limit <= 0) {
        $limit = $defaultLimit;
    }

    // Current Page
    $page = isset($_GET['page'])
        ? (int)$_GET['page']
        : 1;

    if ($page <= 0) {
        $page = 1;
    }

    // OFFSET
    $offset = ($page - 1) * $limit;

    // Total Rows
    $totalQuery = mysqli_query(
        $connect,
        "SELECT COUNT(*) as total FROM $table"
    );

    $totalData = mysqli_fetch_assoc($totalQuery);

    $totalRows = $totalData['total'];

    // Total Pages
    $totalPages = ceil($totalRows / $limit);

    // Fetch Data
    $query = mysqli_query(
        $connect,
        "SELECT * FROM $table
        ORDER BY id DESC
        LIMIT $offset, $limit"
    );

    $data = [];

    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
    }

    return [
        'data' => $data,
        'totalPages' => $totalPages,
        'currentPage' => $page,
        'limit' => $limit
    ];
}
?>

