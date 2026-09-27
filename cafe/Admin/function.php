<?php
include_once('../connection.php');
// global $connect;

function allDetails($table_name)
{
    global $connect;
    $sql = "SELECT * FROM {$table_name} ORDER BY id DESC";
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


