<?php
include '__connect.php';
include '__checkSession.php';
$departmentCode = '';
if (isset($_GET['departmentDode'])) {

    $departmentCode = $_GET['departmentDode'];
}
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];
$statusType = $_GET['statusType'];
$sql = "SELECT * from department where department_code = '$departmentCode'";
$result = mysqli_query($conn, $sql);
$departmentInfo = mysqli_fetch_assoc($result);

require_once __DIR__ . '/vendor/autoload.php';
include '__header.php';
$mpdf = new \Mpdf\Mpdf();

?>
<style>
    @font-face {
        font-family: reportFont;
        src: url('font/THSarabunNew.ttf');
    }

    * {
        font-family: reportFont;
    }

</style>
<script>
    let departmentCode = "<?php echo $departmentCode?>";
    let startDate = "<?php echo $startDate; ?>";
    let endDate = "<?php echo $endDate; ?>";
    let statusType = "<?php echo $statusType; ?>";
    let departmentPunchList;
    let punchTimeList;
    let timeOut;
    let department = {
        dateList: [],
    };

    function getDepartmentPunchList() {
        let searchParam = {
            departmentCode: departmentCode,
            startDate: startDate,
            endDate: endDate,
            statusType:statusType
        };
        $.get("SQL_Select/selectDepartmentPunchTime.php",
            searchParam, (result) => {
                departmentPunchList = JSON.parse(result);
                department.dateList = _.uniqWith(departmentPunchList.map((m) => {
                    return {work_date: m.work_date};
                }), _.isEqual).filter(f => f.work_date != null).map((m) => {
                    let v = m;
                    v.timeStamp = new Date(m.work_timestamp);
                    punchTimeList = departmentPunchList.filter(f => f.work_date == m.work_date);
                    timeOut = punchTimeList.map((x) => {
                        let v2 = x;
                        v2.time_out = departmentPunchList.filter(f => (f.work_out_date == x.work_date && f.emp_id == x.emp_id))[0];
                        if (!v2.time_out) {
                            v2.time_out = null;
                        }
                        return v2;
                    });
                    v.punchTimeList = timeOut;
                    return v;
                });
                department.dateList = _.sortBy(department.dateList, ['timeStamp']);
                let txt = "<table class='table table-bordered'>";
                txt += "<tr class='text-center'>";
                txt += "    <th>วันที่</th>";
                txt += "    <th>พนักงาน</th>";
                txt += "    <th>แผนก</th>";
                txt += "    <th>เวลาเข้า</th>";
                txt += "    <th>สถานะเข้า</th>";
                txt += "    <th>เวลาออก</th>";
                txt += "    <th>สถานะออก</th>";
                txt += "</tr>";
                department.dateList.forEach((f, i) => {
                    f.punchTimeList.forEach((x, j) => {
                        txt += "<tr>";
                        if (j == 0) {
                            txt += "    <td rowspan='" + f.punchTimeList.length + "'>" + f.work_date + "</td>";
                        }
                        let cssIn = x.status_in == 'L' ? "text-danger" : "";

                        txt += "    <td>" + x.emp_id + " : " + x.emp_name + "</td>";
                        txt += "    <td>" + x.department_name + "</td>";
                        txt += "    <td class='text-center'>" + x.in_time + "</td>";
                        txt += "    <td class='text-center " + cssIn + "'>" + x.status_in_name + "</td>";
                        let outTime = "-";
                        let outName = "-";
                        if (x.time_out) {
                            outTime = x.time_out.out_time;
                            outName = x.time_out.status_out_name;
                        }
                        txt += "    <td class='text-center'>" + outTime + "</td>";
                        txt += "    <td class='text-center'>" + outName + "</td>";
                        txt += "</tr>";
                    });
                });
                txt += "</table>";
                $("#reportArea").html(txt);
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
        <h3><strong>รายงานการเข้าออกงาน</strong></h3>
        <h4><strong>ประจำวันที่ <?php echo $startDate; ?> ถึง <?php echo $endDate; ?></strong></h4>
    </div>
    <div id="reportArea">
    </div>
</div>
</body>
</html>

<?php
//$mpdf->Output('filename.pdf', \Mpdf\Output\Destination::FILE);
?>
