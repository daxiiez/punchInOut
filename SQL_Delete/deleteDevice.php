<?php
include '../__connect.php';
$uuid = $_POST['uuid'];
$sql = "DELETE FROM device WHERE uuid = '$uuid'";
$query = mysqli_query($conn, $sql);
echo $query;
