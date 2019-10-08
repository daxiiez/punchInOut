<?php
include '../__connect.php';
$department_code = $_GET['department_code'];
$year = $_GET['year'];
$month = $_GET['month'];
$date = "01-".$month."-".$year;
$sql = "select p.*,
       date_format(p.time_in,'%m-%Y'),
       date_format(p.time_out,'%m-%Y'),
       date_format(p.time_in,'%H:%i'),
       date_format(p.time_out,'%H:%i'),
       p.time_in,
       e.emp_name,
       e.emp_tel,
       sIn.name  as status_in_name,
       sOut.name as status_out_name
from punchtime p
         inner join employee e on p.emp_id = e.emp_id
         left join status_code sIn on sIn.status = p.status_in
         left join status_code sOut on sOut.status = p.status_out
where e.department_code = 'A'
and (date_format(p.time_in,'%m-%Y') = date_format(str_to_date('$date','%d-%m-%Y'),'%m-%Y')
or date_format(p.time_out,'%m-%Y') = date_format(str_to_date('$date','%d-%m-%Y'),'%m-%Y'))";

$query = mysqli_query($conn,$sql);
$dbdata = array();
while ( $temp = mysqli_fetch_array($query,MYSQLI_ASSOC))  {
    $dbdata[]=$temp;
}
echo json_encode($dbdata);
