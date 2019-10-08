<?php
include '__connect.php';
include '__checkSession.php';

$department_code = $_GET['department_code'];
$year = $_GET['year'];
$month = $_GET['month'];
$sql = "SELECT * from department where department_code = '$department_code'";
$result = mysqli_query($conn, $sql);
$departmentInfo = mysqli_fetch_assoc($result);
$sql = "select p.*,
      
       e.emp_name,
       e.emp_tel,
       sIn.name  as status_in_name,
       sOut.name as status_out_name
from punchtime p
         inner join employee e on p.emp_id = e.emp_id
         left join status_code sIn on sIn.status = p.status_in
         left join status_code sOut on sOut.status = p.status_out
where e.department_code = '$department_code'";
$result = mysqli_query($conn, $sql);
$punchDetailInfo = mysqli_fetch_assoc($result);

require_once __DIR__ . '/vendor/autoload.php';
include '__header.php';
$mpdf = new \Mpdf\Mpdf();

?>
<script>
    let departmentCode = "<?php echo $department_code?>";
    let month = "<?php echo $month; ?>";
    let year = "<?php echo $year; ?>";
    let departmentPunchList;
    let department = {};

    function getDepartmentPunchList() {
        $.get("SQL_Select/selectDepartmentPunchTime.php",
            {
                department_code: departmentCode,
                month: month,
                year: year
            }, (result) => {
                departmentPunchList = JSON.parse(result);
            });
    }

    $(document).ready(() => {
        getDepartmentPunchList();
    });
</script>

<html>
<body style="background: white;">
<div class="container-fluid" style="margin-top: 30px;">
    <div align="center">
        <h3 class="font-weight-bold">รายงานการเข้างานของแผนก <?php echo $departmentInfo['name']; ?></h3>
        <h4 class="font-weight-bold">ประจำเดือน <?php echo $month; ?> ปี <?php echo $year; ?></h4>
    </div>
</div>
</body>
</html>


