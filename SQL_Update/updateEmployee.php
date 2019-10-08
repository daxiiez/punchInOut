<?php

include '../__connect.php';
$update_emp_name = $_POST['update_emp_name'];
$update_emp_id = $_POST['update_emp_id'];
$update_emp_card_id = $_POST['update_emp_card_id'];
$update_emp_address = $_POST['update_emp_address'];
$update_emp_tel = $_POST['update_emp_tel'];
$update_emp_gender = $_POST['update_emp_gender'];
$update_emp_pic = $_POST['update_emp_pic'];
$update_emp_start_date = $_POST['update_emp_start_date'];
$update_emp_salaly = $_POST['update_emp_salaly'];
/*$update_emp_username ='';
$update_emp_password ='';
$update_emp_typeuser ='';*/
$update_position_code = '';
$update_department_code = $_POST['update_department_code'];

$sql = "UPDATE punchtime.employee SET  emp_name = '$update_emp_name',
                                        emp_card_id = '$update_emp_card_id', 
                                        emp_address = '$update_emp_address',
                                         emp_tel = '$update_emp_tel',
                                          emp_gender = '$update_emp_gender', 
                                          emp_pic =  FROM_BASE64('$update_emp_pic'),
                                emp_start_date = '$update_emp_start_date', 
                                emp_salaly = '$update_emp_salaly',
                                  department_code = '$update_department_code' WHERE emp_id = '$update_emp_id'";

$query = mysqli_query($conn, $sql);

echo $query;