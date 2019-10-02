<?php
include '../__connect.php';
$sql = "select emp_id,emp_name,emp_tel from employee 
where emp_id not in (select emp_id from punchtime where date(time_in) = date(now()))";
$query = mysqli_query($conn, $sql);
$dbdata = array();
while ($temp = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    $dbdata[] = $temp;
}
echo json_encode($dbdata);
?>