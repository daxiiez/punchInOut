<?php
include '../__connect.php';
$department_code = $_POST['department_code'];
$effective_date = $_POST['effective_date'];
$sql = "delete from departmenttimeinout 
                where department_code = '$department_code' 
                and DATE(effective_date) = str_to_date('$effective_date','%d-%m-%Y')";
$query = mysqli_query($conn, $sql);
echo $query;