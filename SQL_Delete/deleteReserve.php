<?php
include "../__connect.php";
$code = $_POST['code'];
$sql = "select * 
        from booking_detail
        where  student_code ='$code'";
$resultReserve = mysqli_query($conn,$sql);
$rows = mysqli_fetch_assoc($resultReserve);
$tower_no = $rows['tower_no'];
$room_no = $rows['room_no'];
$type = $rows['type'];
$sql = "UPDATE room set current_size = current_size-1 where room_no='$room_no' and tower_no = '$tower_no' and type='$type'";
$resultUpdae = mysqli_query($conn,$sql);
$sql = "delete 
        from booking_detail
        where  student_code ='$code'";
$result = mysqli_query($conn, $sql);
$_SESSION['book_status'] = 'N';
echo json_encode($result);