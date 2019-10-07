<?php
include '../__connect.php';
$update_department_code = $_POST['update_department_code'];
$update_name = $_POST['update_name'];

$sql = "UPDATE department set name = '$update_name'
                    where department_code = '$update_department_code'";

$query = mysqli_query($conn, $sql);

echo $query;
