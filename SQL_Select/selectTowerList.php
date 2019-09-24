<?php
include '../__connect.php';
$sql = "SELECT * from tower";
$query = mysqli_query($conn,$sql);
$dbdata = array();
while ( $temp = mysqli_fetch_array($query,MYSQLI_ASSOC))  {
    $dbdata[]=$temp;
}
echo json_encode($dbdata);