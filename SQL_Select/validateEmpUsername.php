<?php
include '../__connect.php';

$emp_username = $_GET['emp_username'];
$sql = "select emp_id,emp_name from employee where 1=1 ";

if (isset($_GET['emp_username'])) {
    $sql .= " and emp_username = '$emp_username'";
}
$query = mysqli_query($conn,$sql);
$dbData = array();
while ( $temp = mysqli_fetch_array($query,MYSQLI_ASSOC))  {
    $dbData[]=$temp;
}
echo json_encode($dbData);

?>