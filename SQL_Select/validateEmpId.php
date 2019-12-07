<?php
include '../__connect.php';

$emp_id = $_GET['emp_id'];
$sql = "select emp_id,emp_name from employee where 1=1 ";

if (isset($_GET['emp_id'])) {
    $sql .= " and emp_id = '$emp_id'";
}
$query = mysqli_query($conn,$sql);
$dbData = array();
while ( $temp = mysqli_fetch_array($query,MYSQLI_ASSOC))  {
    $dbData[]=$temp;
}
echo json_encode($dbData);

?>