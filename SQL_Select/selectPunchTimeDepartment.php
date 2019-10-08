<?php
include '../__connect.php';
$department_code = $_GET['department_code'];
$sql = "SELECT * FROM departmenttimeinout where department_code = '$department_code' order by effective_date ";
$query = mysqli_query($conn,$sql);
$dbdata = array();
while ( $temp = mysqli_fetch_array($query,MYSQLI_ASSOC))  {
    $dbdata[]=$temp;
}
echo json_encode($dbdata);
