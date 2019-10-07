<?php
include '../__connect.php';
$department_code = $_POST['department_code'];
$sql = "DELETE FROM department WHERE department_code = '$department_code'";
$query = mysqli_query($conn, $sql);
echo $query;
