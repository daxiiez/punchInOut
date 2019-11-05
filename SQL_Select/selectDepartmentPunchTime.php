<?php
include '../__connect.php';

$departmentCode = '';
if (isset($_GET['departmentCode'])) {

    $departmentCode = $_GET['departmentCode'];
}

$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];
$statusType = $_GET['statusType'];
$sql = "select p.*,
       date_format(p.time_in,'%Y-%m-%d')as work_timestamp,
       date_format(p.time_in,'%d')as in_date,
       date_format(p.time_in,'%d-%m-%Y')as work_date,
       date_format(p.time_out,'%d-%m-%Y')as work_out_date,
       date_format(p.time_out,'%d') as out_date,
       date_format(p.time_in,'%H:%i')as in_time,
       date_format(p.time_out,'%H:%i') as out_time,
       p.time_in,
       e.emp_name,
       e.emp_tel,
       e.emp_tel,
       d.name as department_name,
       sIn.name  as status_in_name,
       sOut.name as status_out_name
from punchtime p
         inner join employee e on p.emp_id = e.emp_id
         inner join department d on d.department_code = e.department_code
         left join status_code sIn on sIn.status = p.status_in
         left join status_code sOut on sOut.status = p.status_out
where 1=1
  and (cast(p.time_in as date) between '$startDate' and '$endDate'
    or cast(p.time_out as date) between '$startDate' and '$endDate')";
//  and (cast(p.time_in as date) between '$startDate' and '$endDate'
//    or cast(p.time_out as date) between '$startDate' and '$endDate')";

if ($departmentCode != '') {
    $sql .= " and e.department_code = '$departmentCode' ";
}

if ($statusType != '') {
    if ($statusType == 'L' || $statusType == 'O') {
        $sql .= " and p.status_in = '$statusType' ";
    } else {
        $sql .= " and p.status_out = '$statusType' ";
    }
}

$sql .= " order by p.time_in , e.department_code asc";
//echo $sql;
$query = mysqli_query($conn, $sql);
$dbdata = array();
while ($temp = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    $dbdata[] = $temp;
}
echo json_encode($dbdata);
