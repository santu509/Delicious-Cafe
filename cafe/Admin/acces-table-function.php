<?php
include_once('../connection.php');
function accesstable($table_name){
global $connect;
$sql="select * from {$table_name} group by id";
$run=mysqli_query($connect,$sql);

if($run){
    if(mysqli_num_rows($run)){
        return mysqli_fetch_all($run,MYSQLI_ASSOC);
        
    }
    else{
        return false;
    }
}
else{
    return false;
}
}
?>
