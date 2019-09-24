<?php
include "../__connect.php";
$start_date = $_POST['startDate'];
$end_date = $_POST['endDate'];
$semester = $_POST['semester'];
$year = $_POST['year'];
$tower_no = $_POST['towerNo'];
$tower_type = $_POST['towerType'];
$sql = "delete 
        from booking
        where  start_date = DATE_FORMAT('$start_date','%Y-%m-%d')
                                                                  and end_date = DATE_FORMAT('$end_date','%Y-%m-%d')
                                                                  and semester = $semester
                                                                  and year = $year
                                                                  and tower_no = '$tower_no'
                                                                  and tower_type = '$tower_type'";
$result = mysqli_query($conn, $sql);
echo json_encode($result);