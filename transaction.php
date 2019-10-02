<?php
include '__connect.php';
include '__checkSession.php';
?>
<!Document>
<html>

<head>
    <?php include '__header.php'; ?>
    <script>
        let employeeList, punchList, punchIn;
        let punchDetail = {
            late: 0,
            in: 0,
            nonPunch: 0
        }

        function getPunchTime() {
            $.get("SQL_Select/selectPunchTimeList.php", null, (r) => {
                // console.log(r);
                punchList = JSON.parse(r);
            });
        }

        function displayNonPunchList() {

            $("#linkPunchLate").removeClass("active");
            $("#linkNonPunch").addClass("active");
            $("#linkPunchIn").removeClass("active");
            $.get("SQL_Select/selectNonPunchList.php",null,(r)=>{
                let result = JSON.parse(r);
                let html = "<table class=\"table\">\n" +
                    "                            <tr class='bg-info text-white'>\n" +
                    "                                <th>รหัสพนักงาน</th>\n" +
                    "                                <th>ชื่อพนักงาน</th>\n" +
                    "                                <th>เบอร์โทรศัพท์</th>\n" +
                    "                            </tr>\n";
                result.forEach((f)=>{
                    html += "<tr>";
                    html += "<td>" + f.emp_id + "</td>";
                    html += "<td>" + f.emp_name + "</td>";
                    html += "<td>" + f.emp_tel + "</td>";
                    html += "</tr>";
                });
                html += "                        </table>";
                $("#displayArea").html(html);
            });

        }

        function getEmployeeList() {
            $.get("SQL_Select/selectEmployee.php", null, (r) => {
                employeeList = JSON.parse(r);
            });
        }

        function setChart() {
            const ctx = document.getElementById("myChart");
            let data = [punchDetail.nonPunch, punchDetail.in, punchDetail.late];
            let myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['ยังไม่เข้างาน', 'เข้างานแล้ว', 'เข้างานสาย'],
                    datasets: [{
                        label: 'จำนวนคนเข้างาน',
                        data: data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            // 'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            // 'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    cutoutPercentage: 50,
                    responsive: false,
                }
            });
            displayPunchInList();
        }

        function displayPunchInList() {
            $("#linkPunchLate").removeClass("active");
            $("#linkNonPunch").removeClass("active");
            $("#linkPunchIn").addClass("active");
            let html = "<table class=\"table\">\n" +
                "                            <tr class='text-white bg-primary'>\n" +
                "                                <th>เวลาเข้างาน</th>\n" +
                "                                <th>รหัสพนักงาน</th>\n" +
                "                                <th>ชื่อพนักงาน</th>\n" +
                "                            </tr>\n";
            punchList.filter(f => f.status == 'I').forEach((f) => {
                html += "<tr>";
                html += "<td>" + f.time_in + "</td>";
                html += "<td>" + f.emp_id + "</td>";
                html += "<td>" + f.emp_name + "</td>";
                html += "</tr>";
            })
            html += "                        </table>";
            $("#displayArea").html(html);
        }

        $(document).ready(() => {
            getEmployeeList();
            getPunchTime();
            setTimeout(() => {
                getPunchTimeDetail();
            }, 1000);

        });

        function getPunchTimeDetail() {
            punchDetail.nonPunch = employeeList.length - punchList.length;
            punchDetail.in = punchList.filter(f => f.status == "I").length;
            punchDetail.late = punchList.filter(f => f.status == "L").length;
            setTimeout(() => {
                setChart();
            }, 100)

        }

        function displayPunchLateList() {
            $("#linkPunchLate").addClass("active");
            $("#linkNonPunch").removeClass("active");
            $("#linkPunchIn").removeClass("active");
            let html = "<table class=\"table\">\n" +
                "                            <tr class='bg-warning text-white'>\n" +
                "                                <th>เวลาเข้างาน</th>\n" +
                "                                <th>รหัสพนักงาน</th>\n" +
                "                                <th>ชื่อพนักงาน</th>\n" +
                "                            </tr>\n";
            punchList.filter(f => f.status == 'L').forEach((f) => {
                html += "<tr>";
                html += "<td>" + f.time_in + "</td>";
                html += "<td>" + f.emp_id + "</td>";
                html += "<td>" + f.emp_name + "</td>";
                html += "</tr>";
            })
            html += "                        </table>";
            $("#displayArea").html(html);
        }

    </script>
</head>
<body>
<?php
include '__navbar_admin.php';
?>

<div class="container-fluid" style="margin-top: 10px; margin-bottom: 150px;">
    <div class="card">
        <div class="card-header">
            <nav aria-label="breadcrumb  bg-dark">
                <h5><strong>รายการการเข้า-ออก</strong></h5>
            </nav>
        </div>
        <div class="card-body">
            <!--<ul class="nav nav-pills nav-justified">
                <li class="nav-item">
                    <a class="nav-link active" href="#!">รายการการเข้างาน</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#!">ประวัติการเข้างาน</a>
                </li>
               <li class="nav-item">
                    <a class="nav-link" href="#!">Link</a>
                </li>
            </ul>-->
            <div class="row">
                <div class="col-6">
                    <div align="center">
                        <canvas id="myChart" width="600" height="600"></canvas>
                    </div>
                </div>
                <div class="col-6">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" id="linkPunchIn" onclick="displayPunchInList()" href="#!">เข้างานแล้ว</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="linkPunchLate" onclick="displayPunchLateList()" href="#!">มาสาย</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="linkNonPunch" onclick="displayNonPunchList()" href="#!">ยังไม่เข้างาน</a>
                        </li>
                    </ul>
                    <div class="container-fluid" id="displayArea">
                        <table class="table">
                            <tr>
                                <th>เวลาเข้างาน</th>
                                <th>รหัสพนักงาน</th>
                                <th>ชื่อพนักงาน</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer bg-warning text-white">

        </div>
    </div>
</div>
</body>
</html>
