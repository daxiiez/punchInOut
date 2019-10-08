<?php
include '__connect.php';
include '__checkSession.php';
?>
<!Document>
<html>

<head>
    <?php include '__header.php'; ?>
    <script>
        let yearList;
        let employeeList;
        let departmentList;
        let currentYear;
        let monthList = [
            {
                monthNo: 1,
                monthName: "มกราคม"
            }, {
                monthNo: 2,
                monthName: "กุมภาพันธ์"
            }, {
                monthNo: 3,
                monthName: "มีนาคม"
            }, {
                monthNo: 4,
                monthName: "เมษายน"
            }, {
                monthNo: 5,
                monthName: "พฤษภาคม"
            }, {
                monthNo: 6,
                monthName: "มิถุนายน"
            }, {
                monthNo: 7,
                monthName: "กรกฎาคม"
            }, {
                monthNo: 8,
                monthName: "สิงหาคม"
            }, {
                monthNo: 9,
                monthName: "กันยายน"
            }, {
                monthNo: 10,
                monthName: "ตุลาคม"
            }, {
                monthNo: 11,
                monthName: "พฤศจิกายน"
            }, {
                monthNo: 12,
                monthName: "ธันวาคม"
            }
        ];
        $(document).ready(() => {
            setCurrentYearList();
            setEmployeeList();
            setDepartmentList();
        });

        function setEmployeeList() {
            $.get("SQL_Select/selectEmployee.php", null, (data) => {
                employeeList = JSON.parse(data);
                let txt = "";
                employeeList.forEach((f) => {
                    txt += "<option value='" + f.emp_id + "'>" + f.emp_id + " : " + f.emp_name + "</option>"
                });
                $("#employeeCodeList").html(txt);
            });
        }

        function setDepartmentList() {
            $.get("SQL_Select/selectDepartment.php", null, (data) => {
                employeeList = JSON.parse(data);
                let txt = "";
                employeeList.forEach((f) => {
                    txt += "<option value='" + f.department_code + "'>" + f.department_code + " : " + f.name + "</option>"
                });
                $("#departmentList").html(txt);
            });
        }

        function setCurrentYearList() {
            let year = new Date().getFullYear();
            let txt = "";
            for (let i = year - 2; i <= year; i++) {
                txt += "<option value='" + i + "'>" + i + "</option>";
            }
            $("#year").html(txt);
            $("#year").val(year);
            yearChange();
        }

        function yearChange() {
            let selectedYear = $("#year").val();
            let txt = "";
            let currentYear = new Date().getFullYear();
            if (currentYear == selectedYear) {
                let currentMonth = (new Date().getMonth()) + 1;
                console.log(currentMonth);
                let currentMonthList = monthList.filter(f => (f.monthNo <= currentMonth));
                console.log(currentMonthList);
                currentMonthList.forEach((f) => {
                    txt += "<option value='" + f.monthNo + "'>" + f.monthName + "</option>";
                });
                $("#month").html(txt);
                $("#month").val(currentMonth);
            } else {
                monthList.forEach((f) => {
                    txt += "<option value='" + f.monthNo + "'>" + f.monthName + "</option>";
                });
                $("#month").html(txt);
            }

        }

        function genReportDepartment() {
            let departmentCode = $("#departmentCode").val();
            let month = $("#month").val();
            let year = $("#year").val();
            if(departmentCode){
                window.open("reportDepartment.php?"
                    + "department_code=" + departmentCode
                    + "&month=" + month
                    + "&year=" + year);
            }else{
                alert("กรุณาเลือกรหัสแผนก!");
            }
        }

        function genReportEmployee() {
            let employeeCode = $("#employeeCode").val();
            let month = $("#month").val();
            let year = $("#year").val();
            if(employeeCode){
                window.open("reportEmployee.php?"
                    + "employee_code=" + employeeCode
                    + "&month=" + month
                    + "&year=" + year);
            }else{
                alert("กรุณาเลือกรหัสพนักงาน!");
            }
        }

        function genReportOverAll() {
            let month = $("#month").val();
            let year = $("#year").val();
            window.open("reportOverAll.php?"
                + "month=" + month
                + "&year=" + year);
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
                <h5><strong>รายงาน</strong></h5>
            </nav>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <label>ปี</label>
                    <select class="form-control" id="year">
                        <option></option>
                    </select>
                </div>
                <div class="col-3">
                    <label>เดือน</label>
                    <select class="form-control" id="month">
                        <option></option>
                    </select>
                </div>
            </div>
            <hr>
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col"><strong>รายงานตามแผนก</strong></div>
                        <div class="col">
                            <div class="row">
                                <div class="col-6">
                                    <label class="font-weight-bold">เลือกแผนก</label>
                                    <input placeholder="เลือกแผนก"
                                           class="form-control"
                                           list="departmentList"
                                           id="departmentCode"
                                           name="departmentCode">
                                    <datalist id="departmentList">
                                    </datalist>
                                </div>
                                <div class="col-6">
                                    <div align="right">
                                        <button class="btn btn-sm btn-primary"
                                                onclick="genReportDepartment()">
                                            <i class="fa fa-download"></i> สร้างรายงาน
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class="row">
                        <div class="col">
                            <strong>รายงานตามพนักงาน</strong>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col-6">
                                    <label class="font-weight-bold">เลือกพนักงาน</label>
                                    <input placeholder="เลือกพนักงาน"
                                           class="form-control"
                                           list="employeeCodeList"
                                           id="employeeCode"
                                           name="employeeCode">
                                    <datalist id="employeeCodeList">
                                    </datalist>
                                </div>
                                <div class="col-6">
                                    <div align="right">
                                        <button class="btn btn-sm btn-primary" onclick="genReportEmployee()"><i class="fa fa-download"></i> สร้างรายงาน
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class="row">
                        <div class="col"><strong>รายงานการเข้างานทั้งหมด</strong></div>
                        <div class="col">
                            <div align="right">
                                <button class="btn btn-sm btn-primary" onclick="genReportOverAll()"><i class="fa fa-download"></i> สร้างรายงาน</button>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="footer bg-warning text-white">

        </div>
    </div>
</div>
</body>

</html>
