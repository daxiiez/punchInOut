<?php
include '../__connect.php';
$sql = "select e.emp_name, a.*, s.name as status_name
from punchtime a
         inner join employee e on e.emp_id = a.emp_id
         INNER join status_code s on s.status = a.status_out
where date(time_out) = date(now())";
$query = mysqli_query($conn, $sql);
$dbdata = array();
while ($temp = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    $dbdata[] = $temp;
}
echo json_encode($dbdata);
?>