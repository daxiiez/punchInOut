<?php
include '../__connect.php';
$code = $_POST['code'];
$status = $_POST['status'];
$sql = "UPDATE booking_detail set status='$status' WHERE student_code='$code' ";
$query = mysqli_query($conn,$sql);
echo json_encode($query);