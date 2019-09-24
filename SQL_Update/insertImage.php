<?php
include '../__connect.php';
$roomId = $_POST["roomId"];
$status = 'N';
$img = '';
$info = '';
if (isset($_POST['img'])) {
    $img = $_POST["img"];
}
if (isset($_POST['saveInfo'])) {
    $info = $_POST["saveInfo"];
}
if (isset($_POST['mainFlag'])) {
    $sqlUpdateAll = "UPDATE room_img set main_flag = 'N'  WHERE room_id='$roomId' ";
    $query = mysqli_query($conn, $sqlUpdateAll);
    $status = 'Y';
}
$sql = "INSERT INTO rental.room_img (room_id, room_img_id, img, info, main_flag) 
select '$roomId',max(room_img_id)+1,FROM_BASE64('$img'),'$info','$status' from room_img
";
$query = mysqli_query($conn, $sql);

echo json_encode($query);

