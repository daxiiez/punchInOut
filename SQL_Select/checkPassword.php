<?php
include '../__connect.php';
$username = $_POST['username'];
$password = $_POST['password'];
$isAdmin = $_SESSION['type'];
$table = '';
if($isAdmin=='N') $table='student';
elseif ($isAdmin=='Y') $table='user';

$sql = "select * from $table where username='$username' and password = '$password'";

$query = mysqli_query($conn,$sql);
$result = mysqli_fetch_assoc($query);
if($result){
    echo json_encode(true);
}else{
    echo json_encode(false);
}
