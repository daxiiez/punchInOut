<?php
include '../__connect.php';
$room_no = $_GET['room_no'];
$type = $_GET['type'];
$tower_no = $_GET['tower_no'];

$sql = "select b.start_date,
       b.end_date,
       r.room_no,
       r.tower_no,
       sex.full_status as tower_type,
       r.size,
       s.full_status as room_staus,
       r.cost,
       r.current_size
from room r
       left join status s on s.status = r.status
       left join status sex on sex.status = r.type
       inner join booking b on b.tower_no = r.tower_no
                                 and b.tower_type = r.type
                                 and sysdate() >= b.start_date and sysdate() <= b.end_date
                                 where r.status = 'A'";

$sql = "SELECT * from user where username = '$username'";
$query = mysqli_query($conn,$sql);
$dbdata = array();
//Fetch into associative array
while ( $temp = mysqli_fetch_array($query,MYSQLI_ASSOC))  {
    $dbdata[]=$temp;
}
echo json_encode($dbdata[0]);