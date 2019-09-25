<?php

$update_emp_name = $_POST['update_emp_name'];
$update_emp_card_id = $_POST['update_emp_card_id'];
$update_emp_address = $_POST['update_emp_address'];
$update_emp_tel = $_POST['update_emp_tel'];
$update_emp_gender = $_POST['update_emp_gender'];
$update_emp_pic = $_POST['update_emp_pic'];
$update_emp_start_date = $_POST['update_emp_start_date'];
$update_emp_salaly = $_POST['update_emp_salaly'];
$update_emp_username ='';
$update_emp_password ='';
$update_emp_typeuser ='';
$update_position_code = $_POST['update_position_code'];
$update_department_code = $_POST['update_department_code'];

$sql = "INSERT INTO punchtime.employee (emp_id, emp_name, emp_card_id, emp_address, emp_tel, emp_gender, emp_pic,
                                emp_start_date, emp_salaly, emp_username, emp_password, emp_typeuser, position_code,
                                department_code)
VALUES ( null, '$update_emp_name', '$update_emp_card_id', '$update_emp_address'
       , '$update_emp_tel', '$update_emp_gender'
       , '$update_emp_pic', '$update_emp_start_date'
       , '$update_emp_salaly', '$update_emp_username'
       , '$update_emp_password', '$update_emp_typeuser'
       , '$update_position_code', '$update_department_code')";

$query = mysqli_query($conn, $sql);

echo $query;