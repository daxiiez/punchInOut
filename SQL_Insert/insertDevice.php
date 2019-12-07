<?php
include '../__connect.php';
$insert_uuid = $_POST['insert_uuid'];
$insert_major = "";
$insert_minor = "";
$insert_device_name = $_POST['insert_device_name'];
$insert_status = $_POST['insert_status'];

$sql = "INSERT INTO punchtime.device (uuid, major, minor, device_name, status)
VALUES ('$insert_uuid', '$insert_major', '$insert_minor', '$insert_device_name', '$insert_status')";

$query = mysqli_query($conn, $sql);

echo $query;
?>