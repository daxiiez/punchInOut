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
from employee where 1=1 ";

if(isset($_GET['search'])){
    if(isset($_GET['search_emp_id'])){
        $sql .= " and emp_id like '%".$_GET['search_emp_id']."%'";
    }
    if(isset($_GET['search_emp_name'])){
        $sql .= " and emp_name like '%".$_GET['search_emp_name']."%'";
    }
    if(isset($_GET['search_position_code'])){
        $sql .= " and position_code ='".$_GET['search_position_code']."'";
    }
    if(isset($_GET['search_department_code'])){
        $sql .= " and department_code ='".$_GET['search_department_code']."'";
    }
}

//echo $sql;

$query = mysqli_query($conn,$sql);
$dbdata = array();
while ( $temp = mysqli_fetch_array($query,MYSQLI_ASSOC))  {
    $dbdata[]=$temp;
}
echo json_encode($dbdata);
?>