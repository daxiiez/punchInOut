<?php
include '__connect.php';
include '__checkSession.php';
//เรียกใช้ไฟล์ autoload.php ที่อยู่ใน Folder vendor
//require_once __DIR__ . '/vendor/autoload.php';

$departmentCode = '';
if (isset($_GET['departmentCode'])) {
    $departmentCode = $_GET['departmentCode'];
}
$startDate = $_GET['startDate'];
$startDateDisplay = $_GET['startDateDisplay'];
$endDate = $_GET['endDate'];
$showMac = $_GET['showMac'];
$endDateDisplay = $_GET['endDateDisplay'];
$statusType = $_GET['statusType'];
$sql = "SELECT * from department where department_code = '$departmentCode'";
$result = mysqli_query($conn, $sql);
$departmentInfo = mysqli_fetch_assoc($result);

//$mpdf = new \Mpdf\Mpdf();

require_once 'vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/fonts',
    ]),
    'fontdata' => $fontData + [
            'thsarabun' => [
                'R' => 'THSarabunNew.ttf',
                'I' => 'THSarabunNew Italic.ttf',
                'B' => 'THSarabunNew Bold.ttf',
            ]
        ],
    'default_font' => 'thsarabun'
]);
$reportName = "รายงานการเข้าออกงานประจำวันที่ $startDateDisplay ถึง $endDateDisplay" . ".pdf";
$html = "
            <style>
                .center {
                text-align: center;
                }
                .table {
  width: 100%;
  max-width: 100%;
  background-color: transparent;
}.table th,
.table td {
  padding: 0.5rem;
  vertical-align: top;
}
 .table {
    border-collapse: collapse !important;
  }
.table thead th {
  vertical-align: bottom;
  border-bottom: 0px solid #dee2e6;
}
 .table-bordered th,
  .table-bordered td {
    border: 1px solid  !important;
  }
.table tbody + tbody {
  border-top: 0px solid #dee2e6;
}

.table .table {
  background-color: #fff;
}

.table-sm th,


.table-bordered {
  border: 0px solid;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid;
}



            </style>
            
";
$html .= "
        <h2 class='center'><strong>รายงานการเข้าออกงาน</strong></h2>
        <h3 class='center'><strong>ประจำวันที่ $startDateDisplay ถึง $endDateDisplay</strong></h3>
<table class='table table-bordered'>
    <tr>
        <th>วันที่</th>
        <th>พนักงาน</th>
        <th>แผนก</th>
        <th>เวลาเข้า</th>
        <th>สถานะเข้า</th>
        <th>เวลาออก</th>
        <th>สถานะออก</th>";
if($showMac=="Y"){
    $html.= "<th>MAC Address</th>";
}
$html.="</tr>";
$sql = "select count(*) as total,
date_format(p.time_in,'%d-%m-%Y') as work_date,
date_format(p.time_in,'%Y-%m-%d') as work_date_ff 
from punchtime p 
inner join employee e on p.emp_id = e.emp_id
where (cast(p.time_in as date) between '$startDate' and '$endDate'
    or cast(p.time_out as date) between '$startDate' and '$endDate') ";
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
$sql .= " group by date_format(p.time_in,'%d-%m-%Y'),date_format(p.time_in,'%Y-%m-%d') order by p.time_in;";
$query = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    $html .= "<tr><td rowspan='" . ($row['total'] + 1) . "'>" . $row['work_date'] . "</td></tr>";
    $workDate = $row['work_date_ff'];
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
where 1=1 ";
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
    $sql .= "  and cast(p.time_in as date) = '$workDate'";
    $resultRow = mysqli_query($conn, $sql);
    while ($temp = mysqli_fetch_array($resultRow, MYSQLI_ASSOC)) {
        $html .= "<tr>";
        $html .= "<td>" . $temp['emp_id'] . " : " . $temp['emp_name'] . "</td>";
        $html .= "<td>" . $temp['department_name'] . "</td>";
        $html .= "<td>" . $temp['in_time'] . "</td>";
        $html .= "<td>" . $temp['status_in_name'] . "</td>";
        $html .= "<td>" . $temp['out_time'] . "</td>";
        $html .= "<td>" . $temp['status_out_name'] . "</td>";
        if($showMac=="Y"){
            $html .= "<td>".$temp['mac_address']."</td>";
        }
        $html .= "</tr>";
    }

}
$html .= "</table>";
//echo $html;
$mpdf->WriteHTML($html);
$mpdf->Output($reportName, 'I');