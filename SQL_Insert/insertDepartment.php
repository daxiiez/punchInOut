<?php
include '../__connect.php';
$insert_department_code = $_POST['insert_department_code'];
$insert_name = $_POST['insert_name'];

$sql = "INSERT INTO department (department_code, name)
             VALUES ('$insert_department_code', '$insert_name')";

$query = mysqli_query($conn, $sql);

echo $query;
?>