<?php
include '../__connect.php';
$roomId = $_POST["roomId"];
$imgId = $_POST["imgId"];
$info = $_POST["saveInfo"];


$sql = "UPDATE room_img set info='$info' ";
if(isset($_POST['img'])){
    $img = $_POST["img"];
    $sql .= ",img=FROM_BASE64('$img')";
}
if (isset($_POST['mainFlag'])) {
    $sql .= ",main_flag = 'Y'";
    $sqlUpdateAll = "UPDATE room_img set main_flag = 'N'  WHERE room_id='$roomId' ";
    $query = mysqli_query($conn, $sqlUpdateAll);
}
$sql .= "  WHERE room_img_id='$imgId'";

$query = mysqli_query($conn, $sql);

echo json_encode($query);






