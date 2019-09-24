<?php
include "../__connect.php";
$imgId = $_POST['imgId'];
$sql = "delete 
        from room_img
        where  room_img_id ='$imgId'";
$result = mysqli_query($conn, $sql);
echo json_encode($result);