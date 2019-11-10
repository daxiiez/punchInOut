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
            setEmployeeList();
            setDepartmentList();
            setDatePicker();
        });

        function setDatePicker() {
            $('#startDate').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'dd-mm-yyyy'
            });
            $('#endDate').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'dd-mm-yyyy'
            });
        };

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
                let txt = "<option value=''>--เลือกแผนก--</option>";
                employeeList.forEach((f) => {
                    txt += "<option value='" + f.department_code + "'>" + f.department_code + " : " + f.name + "</option>"
                });
                $("#departmentCode").html(txt);
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
            if (departmentCode) {
                window.open("reportDepartment.php?"
                    + "department_code=" + departmentCode
                    + "&month=" + month
                    + "&year=" + year);
            } else {
                alert("กรุณาเลือกรหัสแผนก!");
            }
        }

        function genReportEmployee() {
            let employeeCode = $("#employeeCode").val();
            let month = $("#month").val();
            let year = $("#year").val();
            if (employeeCode) {
                window.open("reportEmployee.php?"
                    + "employee_code=" + employeeCode
                    + "&month=" + month
                    + "&year=" + year);
            } else {
                alert("กรุณาเลือกรหัสพนักงาน!");
            }
        }

        function strToDate(str) {
            let txt = str.split("-");
            let length = txt.length;
            return new Date(txt[length - 1] + "-" + txt[length - 2] + "-" + txt[length - 3])
        }

        function strToDate543(str) {
            let txt = str.split("-");
            let length = txt.length;
            return (Number(txt[length - 1])) + "-" + txt[length - 2] + "-" + txt[length - 3];
        }

        function gentReport() {
            let startDate = $("#startDate").val();
            let endDate = $("#endDate").val();
            let statusType = $("#statusType").val();
            if (startDate && endDate) {
                if (strToDate(endDate) < strToDate(startDate)) {
                    alert("เลือกวันที่ไม่ถูกต้องวันที่เริ่มต้นต้องกว่าวันที่สิ้นสุด!")
                } else {
                    let departmentCode = $("#departmentCode").val();
                    window.open("reportEmployee.php?"
                        + "startDateDisplay=" + (startDate)
                        + "&endDateDisplay=" + (endDate)
                        + "&startDate=" + strToDate543(startDate)
                        + "&endDate=" + strToDate543(endDate)
                        + "&departmentCode=" + departmentCode
                        + "&statusType=" + statusType);
                }
            } else {
                alert("กรุณาเลือกวันที่ให้ครบ!")
            }
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
                    <label class="font-weight-bold">เริ่มวันที่</label>
                    <input readonly class="form-control" id="startDate"
                           name="startDate">
                </div>
                <div class="col-3">
                    <label class="font-weight-bold">ถึงวันที่</label>
                    <input readonly class="form-control" id="endDate"
                           name="endDate">
                </div>
                <div class="col-2">
                    <label class="font-weight-bold">เลือกแผนก</label>
                    <select  id="departmentCode"
                             class="form-control"
                             name="departmentCode">
                    </select>
                </div>
                <div class="col-2">
                    <label class="font-weight-bold">เลือกประเภทการเข้า-ออกงาน</label>
                    <select placeholder="เลือกแผนก"
                           class="form-control"
                           list="departmentList"
                           id="statusType"
                           name="statusType">
                        <option value="">--เลือก--</option>
                        <option value="I">เข้างานปกติ</option>
                        <option value="L">เข้างานสาย</option>
                        <option value="O">ออกปกติ</option>
                        <option value="B">ออกก่อนเวลา</option>
                    </select>
                </div>
                <div class="col-2">
                    <div align="left">
                        <button style="margin-top: 30px;"
                                class="btn btn-primary"
                                onclick="gentReport()">
                            <i class="fa fa-download"></i> สร้างรายงาน
                        </button>
                    </div>
                </div>
                <hr>
            </div>
            <div class="footer bg-warning text-white">

            </div>
        </div>
    </div>
</body>

</html>
