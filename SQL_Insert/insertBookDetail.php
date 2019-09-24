<?php
include '../__connect.php';
if ($_POST) {
    $code = $_SESSION['code'];
    $room_no = $_POST['room_no'];
    $tower_no = $_POST['tower_no'];
    $type = $_POST['type'];

    $sql = "INSERT INTO booking_detail (`book_date`, `type`, `tower_no`, `room_no`, `student_code`, `status`,`score`)
VALUES (sysdate(), '$type', '$tower_no', '$room_no', '$code', 'N',100)";
    $_SESSION['book_status'] = 'Y';
    $query = mysqli_query($conn, $sql);
    $sql = "UPDATE room set current_size = current_size+1 where type='$type' and room_no='$room_no' and tower_no='$tower_no'";
    $result = mysqli_query($conn, $sql);
    echo json_encode($query);
}

