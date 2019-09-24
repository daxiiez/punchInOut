<?php
include '../__connect.php';
$room_no = $_GET['room_no'];
$tower_no = $_GET['tower_no'];
$type = $_GET['type'];
$sql = "SELECT d.book_date,type.full_status,tower_no,room_no,s.code,s.name,s.tel,s.level,s.major,status.full_status,s.department,s.tel
 from booking_detail d 
 inner join student s on s.code = d.student_code 
 inner join status status on status.status = d.status
 inner join status type on type.status = d.type
 where room_no ='$room_no' and tower_no='$tower_no' and type='$type'";

$query = mysqli_query($conn,$sql);
$dbdata = array();
while ( $temp = mysqli_fetch_array($query,MYSQLI_ASSOC))  {
    $dbdata[]=$temp;
}
echo json_encode($dbdata);