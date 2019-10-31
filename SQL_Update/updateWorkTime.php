<?php
include '../__connect.php';

$department_code = $_POST['insert_department_code'];
$time_in = $_POST['insert_time_in'];
$time_out = $_POST['insert_time_out'];

$sql = "
UPDATE  departmenttimeinout 
SET
time_in = '$time_in' ,
time_out = '$time_out' 
WHERE department_code = '$department_code'";


$query = mysqli_query($conn, $sql);

echo $query;