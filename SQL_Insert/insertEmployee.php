<?php
include '../__connect.php';
$emp_name = $_POST['emp_name'];
$emp_card_id = $_POST['emp_card_id'];
$emp_address = $_POST['emp_address'];
$emp_tel = $_POST['emp_tel'];
$emp_gender = $_POST['emp_gender'];
$emp_pic = $_POST['emp_pic'];
$emp_start_date = $_POST['emp_start_date'];
$emp_salaly = $_POST['emp_salaly'];
$emp_username ='';
$emp_password ='';
$emp_typeuser ='';
$position_code = $_POST['position_code'];
$department_code = $_POST['department_code'];

$sql = "INSERT INTO punchtime.employee (emp_id, emp_name, emp_card_id, emp_address, emp_tel, emp_gender, emp_pic,
                                emp_start_date, emp_salaly, emp_username, emp_password, emp_typeuser, position_code,
                                department_code)
VALUES (null, '$emp_name', '$emp_card_id', '$emp_address', '$emp_tel', '$emp_gender', FROM_BASE64('$emp_pic'),
        '$emp_start_date', '$emp_salaly', '$emp_username', '$emp_password', '$emp_typeuser', '$position_code',
        '$department_code')";

$query = mysqli_query($conn, $sql);

echo $query;
?>