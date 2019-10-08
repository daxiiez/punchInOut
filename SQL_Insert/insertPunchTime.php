<?php
include '../__connect.php';

$department_code = $_POST['insert_department_code'];
$time_in = $_POST['insert_time_in'];
$time_out = $_POST['insert_time_out'];
$effective_date = $_POST['insert_effective_date'];

$sql = "INSERT INTO departmenttimeinout (department_code, time_in, time_out, effective_date)
VALUES ('$department_code', '$time_in', '$time_out', str_to_date('$effective_date','%d-%m-%Y'))";

$query = mysqli_query($conn, $sql);

echo $query;
?>