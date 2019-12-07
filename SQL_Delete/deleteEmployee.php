<?php
include '../__connect.php';
$emp_id = $_POST['emp_id'];
$sql = "DELETE FROM employee WHERE emp_id = '$emp_id'";
$query = mysqli_query($conn, $sql);
echo $query;
