<?php
include '__connect.php';
include '__checkSession.php';
?>
<!Document>
<html>

<head>
    <?php include '__header.php'; ?>
    <script>
        let departmentList;
        let selectDepartment;
        let punchTimeList;
        let effectiveList;
        let futureList;
        $(document).ready(() => {
            getDepartmentList();
            setDatePicker();
        });

        function setDatePicker() {
            $('#insert_effective_date').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'dd-mm-yyyy'
            });
        };

        function getDepartmentList() {
            $.get("SQL_Select/selectDepartment.php", null, (r) => {
                departmentList = JSON.parse(r);

                let txt = "<table class='table table-bordered '>";
                txt += "<tr class='bg-info text-white'>";
                txt += "    <th width='10%'>#</th>";
                txt += "    <th width='40%'>รหัสแผนก</th>";
                txt += "    <th width='45%'>ชื่อแผนก</th>";
                txt += "    <th width='15%'>แก้ไข</th>";
                txt += "<tr>";
                departmentList.forEach((f, i) => {
                    txt += "<tr>";
                    txt += "    <td>" + (i + 1) + "</td>";
                    txt += "    <td>" + f.department_code + "</td>";
                    txt += "    <td>" + f.name + "</td>";
                    txt += "    <td>" +
                        "<div align='right'>" +
                        "<div class='btn-group'> " +
                        "<button onclick='editDetail(" + '"' + f.department_code + '"' + ")' class='btn btn-primary'><i class='fa fa-edit'></i> แก้ไข</button>" +
                        "<button onclick='showPunchTime(" + '"' + f.department_code + '"' + ")' class='btn btn-outline-success'><i class='fa fa-list'></i> ดูข้อมูลการเข้างาน</button>" +
                        "</div>" +
                        "</div>" +
                        "</td>";
                    txt += "<tr>";
                });
                txt += "</table>";
                $("#departmentArea").html(txt);
            });
        }

        function validateFrom(obj) {
            console.log(obj);
            for (let i in obj) {
                if (!obj[i]) {
                    alert("กรุณากรอกข้อมูลให้ครบถ้วน")
                    return false;
                }
            }
            return true;
        }

        function editDetail(department_code) {
            let em = departmentList.filter(f => f.department_code == department_code)[0];
            _.mapValues(em, (v, k) => {
                try {
                    $("#update_" + k).val(v);
                } catch (e) {
                }
            });

            $('#updateDepartmentModal').modal('toggle');
        }

        function insertDepartment() {
            console.log("Insert Department");
            let departmentObj = arrayToObject($("#addDepartmentForm").serializeArray());
            if (validateFrom(departmentObj)) {
                $.post("SQL_Insert/insertDepartment.php", departmentObj, (result) => {
                    if (result == "result" || result == true) {
                        alert("เพิ่มข้อมูลอุปกรณ์สำเร็จ!");
                        location.reload();
                    }
                });
            } else {
                alert("กรุณากรอกข้อมูลให้ครบถ้วน")
            }
        }

        function updateDepartment() {
            let updateObj = arrayToObject($("#updateDepartmentForm").serializeArray());
            console.log(updateObj);
            $.post("SQL_Update/updateDepartment.php", updateObj, (result) => {
                if (result == "result" || result == true) {
                    alert("แก้ไขข้อมูลอุปกรณ์!");
                    getDepartmentList()
                }
            });
        }

        function showPunchTime(department_code) {
            selectDepartment = department_code;
            let name = departmentList.filter((f) => f.department_code == department_code)[0].name;
            $("#departmentPunchTimeHeader").html("<h3><strong>เวลาเข้างานของแผนก" + name + "</h3></strong>");
            selectPunchTime(department_code);
            $("#punchTimeSettingModal").modal('toggle');
        }

        function selectPunchTime(department_code) {

            $.get("SQL_Select/selectPunchTimeDepartment.php", {department_code: department_code}, (r) => {
                    r = JSON.parse(r);
                    let html = "";
                    punchTimeList = r.map((m) => {
                        let v = m;
                        v.effective_date_date = new Date(m.effective_date);
                        return v;
                    });

                    effectiveList = punchTimeList.filter(f => (f.effective_date_date <= new Date()));
                    effectiveList = effectiveList[effectiveList.length - 1];
                    if (effectiveList.length != 0) {
                        html += "<td>" + dateFormat(effectiveList.effective_date_date) + "</td>";
                        html += "<td>" + effectiveList.time_in.substr(0, 2) + ":" + effectiveList.time_in.substr(2, 2) + "</td>"
                        html += "<td>" + effectiveList.time_out.substr(0, 2) + ":" + effectiveList.time_out.substr(2, 2) + "</td>"
                        $("#effectiveTimeList").html(html);
                    } else {
                        $("#effectiveTimeList").html("<td colspan='3' class='text-center'>ยังไม่มีข้อมูล</td>");
                    }

                    futureList = punchTimeList.filter(f => (f.effective_date_date > new Date()));

                    html = "<tr>" +
                        "       <th>#</th>" +
                        "       <th>วันที่มีผล</th>" +
                        "       <th>เวลาเข้า</th>" +
                        "       <th>เวลาออก</th>" +
                        "       <th>แก้ไข</th>" +
                        "   </tr>";

                    if (futureList.length != 0) {
                        futureList.forEach((f, i) => {
                            html += "<tr>";
                            html += "<td>" + (i + 1) + "</td>";
                            html += "<td>" + dateFormat(f.effective_date_date) + "</td>";
                            html += "<td>" + f.time_in.substr(0, 2) + ":" + f.time_in.substr(2, 2) + "</td>"
                            html += "<td>" + f.time_out.substr(0, 2) + ":" + f.time_out.substr(2, 2) + "</td>"
                            html += "<td>" +
                                "<div class='btn-group'>" +
                                "<button class='btn btn-danger'  onclick='deletePunchTime(" + '"' + f.department_code + '","' + f.effective_date + '"' + ")'><i class='fa fa-trash'></i> ลบ</button>" +
                                "</div>" +
                                "</td>";
                            html += "</tr>";
                        });
                        $("#futureTimeList").html(html);
                    } else {
                        $("#futureTimeList").html("<td colspan='4' class='text-center'>ยังไม่มีข้อมูล</td>");
                    }
                }
            );
        }

        function deletePunchTime(department_code, effective_date) {
            let deletePunchTime = {
                department_code: department_code,
                effective_date: dateFormat(new Date(effective_date))
            }
            console.log(deletePunchTime);
            if (confirm("ยืนยันลบกะเวลานี้ ?")) {
                $.post("SQL_Delete/deletePunchTime.php", deletePunchTime, (result) => {
                    if (result == "result" || result == true) {
                        alert("ลบข้อมูลสำเร็จ!");
                        selectPunchTime(department_code);
                    }
                });
            }
        }

        function insertPunchTime() {
            if (validatePunchTime()) {
                console.log("Insert Department");
                let punchTimeObj = arrayToObject($("#insertPunchTimeForm").serializeArray());
                punchTimeObj['insert_department_code'] = selectDepartment;
                $.post("SQL_Insert/insertPunchTime.php", punchTimeObj, (result) => {
                    if (result == "result" || result == true) {
                        alert("เพิ่มข้อมูลสำเร็จ!");
                        $("#insert_time_in").val("");
                        $("#insert_time_out").val("");
                        $("#insert_effective_date").val("");
                        selectPunchTime(selectDepartment);
                    }
                });
            }
        }

        function checkMinute(mm) {
            return Number(mm) <= 59 && Number(mm) >= 0;
        }

        function checkHour(hh) {
            return Number(hh) <= 23 && Number(hh) >= 0;
        }

        function validatePunchTime() {
            let punchTimeObj = arrayToObject($("#insertPunchTimeForm").serializeArray());
            if (validateFrom(punchTimeObj)) {
                let timeIn = $("#insert_time_in").val();
                let timeOut = $("#insert_time_out").val();
                let hhIn = timeIn.substr(0, 2);
                let mmIn = timeIn.substr(2, 2);
                let hhOut = timeOut.substr(0, 2);
                let mmOut = timeOut.substr(2, 2);
                if (checkMinute(mmIn)
                    && checkMinute(mmOut)
                    && checkHour(hhIn)
                    && checkHour(hhOut)
                    && Number(timeOut) > Number(timeIn)) {
                    return true;
                } else {
                    alert("ข้อมูล เวลาเข้า-เวลาออก ไม่ถูกต้องกรุณาตรวจสอบ")
                    return false;
                }
            } else {
                return false;
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
                <h5><strong>ข้อมูลแผนก</strong></h5>
            </nav>
        </div>
        <div class="card-body">
            <div align="right">
                <button class="btn btn-outline-success" type="button" data-toggle="modal"
                        data-target="#addDepartmentModal">
                    <i class="fa fa-plus"></i> เพิ่มแผนก
                </button>
                <br>
            </div>

            <div id="departmentArea">

            </div>
        </div>
        <div class="footer bg-warning text-white">

        </div>
    </div>
</div>

<div class="modal fade" id="addDepartmentModal" role="dialog" aria-labelledby="addDepartmentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form name="addDepartmentForm" id="addDepartmentForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDepartmentLabel"><i class="fa fa-plus"></i> เพิ่มรายชื่อพนักงาน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>รหัสแผนก</label>
                                        <input name="insert_department_code" id="insert_department_code" maxlength="1"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>ชื่อแผนก</label>
                                        <input name="insert_name" id="insert_name" class="form-control">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-block">
                        <button type="button" onclick="insertDepartment()" class="btn btn-primary"><i
                                    class="fa fa-save"></i> บันทึก
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="updateDepartmentModal" role="dialog" aria-labelledby="updateDepartmentModal"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="updateDepartmentForm" id="updateDepartmentForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateDepartmentLabel"><i class="fa fa-edit"></i> แก้ไขข้อมูลอุปกรณ์
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>รหัสแผนก</label>
                                    <input readonly name="update_department_code" id="update_department_code"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>ชื่อแผนก</label>
                                    <input name="update_name" id="update_name" class="form-control">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-block">
                        <button type="button" onclick="updateDepartment()" class="btn btn-primary"><i
                                    class="fa fa-save"></i> บันทึก
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="punchTimeSettingModal" role="dialog" aria-labelledby="punchTimeSettingModal"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" id="departmentPunchTimeHeader">

            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <strong>กะเวลาที่มีผลอยู่</strong>
                    </div>
                    <div class="body">
                        <table class="table">
                            <tr>
                                <th>วันที่มีผล</th>
                                <th>เวลาเข้า</th>
                                <th>เวลาออก</th>
                            </tr>
                            <tr id="effectiveTimeList">

                            </tr>
                        </table>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header">
                        <strong>กะเวลาล่วงหน้า</strong>
                    </div>
                    <div class="body">
                        <table class="table" id="futureTimeList">
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <div align="right" style="padding-top: 10px;">
                    <button class="btn btn-outline-info" type="button" data-toggle="modal"
                            data-target="#addPunchTimeModal"><i class="fa fa-plus"></i> เพิ่มกะเวลา
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" style="padding-top: 70px;" id="addPunchTimeModal" role="dialog"
     aria-labelledby="addPunchTimeModal" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content bg-success text-white">
            <div class="modal-header">
                <h3><strong>เพิ่มกะเวลา</strong></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="insertPunchTimeForm">

                        <div class="col-12">
                            <label>เวลาเข้า</label>
                            <input class="form-control" placeholder="HHMM" id="insert_time_in" maxlength="4"
                                   name="insert_time_in">
                        </div>
                        <div class="col-12">
                            <label>เวลาออก</label>
                            <input class="form-control" placeholder="HHMM" id="insert_time_out" maxlength="4"
                                   name="insert_time_out">
                        </div>
                        <div class="col-12 text-white">
                            <label>วันที่มีผล</label>
                            <input readonly class="form-control" id="insert_effective_date"
                                   name="insert_effective_date">
                        </div>
                    </form>
                </div>
                <small><i>*กรุณากรอกเวลาเข้าด้วยรูปแบบ HHMM<br>HH : 00-23 <br>MM : 00-59</i></small>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-dark text-white" onclick="insertPunchTime()"><i class="fa fa-save"></i>
                    เพิ่มกะเวลา
                </button>
            </div>
        </div>
    </div>
</div>

</body>

</html>
