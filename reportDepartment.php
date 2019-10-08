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
    let department = {
        dateList: [],

    };

    function getDepartmentPunchList() {
        let searchParam = {
            department_code: departmentCode,
            month: month,
            year: year
        };
        $.get("SQL_Select/selectDepartmentPunchTime.php",
            searchParam, (result) => {
                departmentPunchList = JSON.parse(result);
                department.dateList = _.uniqWith(departmentPunchList.map((m) => {
                    return {in_date: m.in_date};
                }), _.isEqual).filter(f => f.in_date != null).map((m) => {
                    let v = m;
                    v.punchTimeList = departmentPunchList.filter(f => f.in_date == m.in_date).map((x) => {
                        let v2 = x;
                        v2.time_out = departmentPunchList.filter(f => (f.out_date == x.in_date && f.emp_id == x.emp_id))[0];
                        if (!v2.time_out) {
                            v2.time_out = null;
                        }
                        return v2;
                    })
                    return v;
                });
                let txt = "<table class='table table-bordered'>";
                txt += "<tr class='text-center'>";
                txt += "    <th>วันที่</th>";
                txt += "    <th>พนักงาน</th>";
                txt += "    <th>เวลาเข้า</th>";
                txt += "    <th>สถานะเข้า</th>";
                txt += "    <th>เวลาออก</th>";
                txt += "    <th>สถานะออก</th>";
                txt += "</tr>";
                department.dateList.forEach((f,i) => {
                    f.punchTimeList.forEach((x,j)=>{
                        txt += "<tr>";
                        if(i==0 && j==0){
                            txt += "    <td rowspan='"+f.punchTimeList.length+"'>" + f.in_date + "</td>";
                        }
                        let cssIn = x.status_in=='L' ? "text-danger":"";

                        txt += "    <td>" + x.emp_id + " : " + x.emp_name + "</td>";
                        txt += "    <td class='text-center'>" + x.in_time + "</td>";
                        txt += "    <td class='text-center "+cssIn+"'>" + x.status_in_name + "</td>";
                        let outTime = "-";
                        let outName = "-";
                        if(x.out_time){
                            outTime = x.out_time;
                            outName = x.status_in_name;
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
        <h3 class="font-weight-bold">รายงานการเข้างานของแผนก <?php echo $departmentInfo['name']; ?></h3>
        <h4 class="font-weight-bold">ประจำเดือน <?php echo $month; ?> ปี <?php echo $year; ?></h4>
    </div>
    <div id="reportArea">
    </div>
</div>
</body>
</html>


