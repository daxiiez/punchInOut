<?php
include '../__connect.php';
$sql = "select emp_id,
       emp_name,
       emp_card_id,
       emp_address,
       emp_tel,
       emp_gender,
       TO_BASE64(emp_pic) as emp_pic,
       emp_start_date,
       emp_salaly,
       emp_username,
       emp_password,
       emp_typeuser,
       position_code,
       department_code
from employee";
$query = mysqli_query($conn,$sql);
$dbdata = array();
while ( $temp = mysqli_fetch_array($query,MYSQLI_ASSOC))  {
    $dbdata[]=$temp;
}
echo json_encode($dbdata);
?>