<?php
include '../__connect.php';
$update_uuid = $_POST['update_uuid'];
$update_major = $_POST['update_major'];
$update_minor = $_POST['update_minor'];
$update_device_name = $_POST['update_device_name'];
$update_status = $_POST['update_status'];

$sql = "UPDATE device set major = '$update_major',
                          minor = '$update_minor',
                          device_name = '$update_device_name',
                          status = '$update_status',
                          major = '$update_major'
                         ,uuid = '$update_uuid'
                    where uuid = '$update_uuid'";

$query = mysqli_query($conn, $sql);

echo $query;
