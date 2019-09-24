<?php
include '../__connect.php';
$saveRoomNo = $_POST["saveRoomNo"];
$saveRoomSize = $_POST["saveRoomSize"];
$saveRoomCost = $_POST["saveRoomCost"];
$saveRoomStatus = $_POST["saveRoomStatus"];
$sql = "UPDATE room set room_id='$saveRoomNo',size='$saveRoomSize',cost='$saveRoomCost',status='$saveRoomStatus' WHERE room_id='$saveRoomNo' ";
$query = mysqli_query($conn, $sql);
echo json_encode($query);