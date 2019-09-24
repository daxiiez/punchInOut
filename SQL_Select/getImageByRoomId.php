<?php
include '../__connect.php';
$roomId = $_GET['roomId'];
$sql = "SELECT room_id,room_img_id,TO_BASE64(img) as room_img,info from room_img where room_id = '$roomId' ORDER BY main_flag desc";
$query = mysqli_query($conn,$sql);
$dbdata = array();
while ( $temp = mysqli_fetch_array($query,MYSQLI_ASSOC))  {
    $dbdata[]=$temp;
}
echo json_encode($dbdata);