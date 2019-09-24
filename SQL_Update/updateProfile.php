<?php
include "../__connect.php";
$tel = $_POST['tel'];
$name = $_POST['name'];
$username = $_POST['username'];
$newPassword = $_POST['newPassword'];
$address = $_POST['address'];
$sql = "update user set name ='$name' , tel='$tel' , address = '$address' ";
if($_POST['isPasswordChange']=='true'){
    $sql.=" ,password = '$newPassword'";
}
$sql.= "where username = '$username'";
$result = mysqli_query($conn,$sql);
$_SESSION['tel'] = $_POST['tel'];
$_SESSION['address'] = $_POST['address'];
$_SESSION['name'] = $_POST['name'];

echo $result;