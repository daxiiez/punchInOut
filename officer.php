<?php
include '__connect.php';
include '__checkSession.php';
?>
<!Document>
<html>

<head>
    <?php include '__header.php'; ?>
    <script>
        let employeeList, departmentList, positionList;
        let imgFile;
        $(document).ready(() => {
            setDatePicker();
            getDepartmentList();
            getPositionList();
            setTimeout(() => {
                getOfficerList();
            }, 500);

            function readURL(input, id) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        imgFile = e.target.result.replace(/^data:image\/[a-z]+;base64,/, "");
                        $(id).attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                    readFile(input.files[0], function (e) {
                    });
                }
            };

            function readFile(file, callback) {
                var reader = new FileReader();
                reader.onload = callback
                reader.readAsText(file);
            };

            $("#imgInp").change(function () {
                readURL(this, '#img-upload');
            });
        });

        function setDatePicker() {
            $('#emp_start_date').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'dd/mm/yyyy'
            });
        };

        function getDepartmentList() {
            $.get("SQL_Select/selectDepartment.php", null, (data) => {
                departmentList = JSON.parse(data);
                let departmentListTxt = "";
                departmentList.forEach(f => {
                    departmentListTxt += "<option value='" + f.department_code + "'>" + f.name + "</option>"
                })
                $("#department_code").html(departmentListTxt);
                departmentListTxt = "<option value=''>-- เลือกตำแหน่ง --</option>" + departmentListTxt;
                $("#search_department_code").html(departmentListTxt);

            });
        };

        function getPositionList() {
            $.get("SQL_Select/selectPosition.php", null, (data) => {
                positionList = JSON.parse(data);
                let positionListTxt = "";
                positionList.forEach(f => {
                    positionListTxt += "<option value='" + f.position_code + "'>" + f.name + "</option>"
                })
                $("#position_code").html(positionListTxt);
                positionListTxt = "<option value=''>-- เลือกตำแหน่ง --</option>" + positionListTxt;
                $("#search_position_code").html(positionListTxt);
            });
        };

        function getOfficerList() {
            $.get("SQL_Select/selectEmployee.php", null, (data) => {
                employeeList = JSON.parse(data);
                if (employeeList) {
                    setEmployeeList();
                } else {
                    alert("ไม่พบข้อมูล");
                }
            });
        };

        function setEmployeeList() {
            let html = "<div class='row'>";
            employeeList.forEach(f => {
                let positionName = positionList.filter(x => f.position_code == x.position_code)[0].name;
                let departmentName = departmentList.filter(x => f.department_code == x.department_code)[0].name;
                html += "                        <div class='col-3' style='margin-bottom: 10px;'>" +
                    "                            <div class='card'>" +
                    "                                <div class='card-header'><strong>รหัส : " + f.emp_id + "</strong></div>" +
                    "                                <div class='card-body'>" +
                    "                                    <table class='table'>" +
                    "                                        <tr>" +
                    "                                            <td colspan='2'>" +
                    "                                               <img  class='card-img-top' width='100%'" +
                    "                                                     border='5'" +
                    "                                                     name='imageShow'" +
                    "                                                     src='data:image/jpeg;base64," + f.emp_pic + "'>" +
                    "                                           </td>" +
                    "                                        </tr>" +
                    "                                        <tr>" +
                    "                                            <th>ชื่อ</th>" +
                    "                                            <td>" + f.emp_name + "</td>" +
                    "                                        </tr>" +
                    "                                        <tr>" +
                    "                                            <th>เบอร์โทร</th>" +
                    "                                            <td>" + f.emp_tel + "</td>" +
                    "                                        </tr>" +
                    "                                        <tr>" +
                    "                                            <th>ตำแหน่ง</th>" +
                    "                                            <td>" + positionName + "</td>" +
                    "                                        </tr>" +
                    "                                        <tr>" +
                    "                                            <th>แผนก</th>" +
                    "                                            <td>" + departmentName + "</td>" +
                    "                                        </tr>" +
                    "                                        <tr>" +
                    "                                        </tr>" +
                    "                                    </table>" +
                    "                                </div>" +
                    "                                <div class='card-footer'>" +
                    "                                    <button onclick='viewEmployeeDetail(" + f.emp_id + ")' class='btn-block btn btn-outline-info'>" +
                    "                                        ดู/แก้ไข ข้อมูลพนักงาน" +
                    "                                    </button>" +
                    "                                </div>" +
                    "                            </div>" +
                    "                        </div>";
            });
            html += "                    </div>";
            $("#employeeList").html(html);
        };

        function viewEmployeeDetail(emp_id) {
            let em = employeeList.filter(f => f.emp_id == emp_id)[0];
            console.log("em ", em);
        };

        function insertEmployee() {
            console.log("Insert Employee")
            let employeeObj = arrayToObject($("#addEmployeeForm").serializeArray());
            employeeObj["emp_pic"] = imgFile;
            console.log("employeeObj : ", employeeObj);
            $.post("SQL_Insert/insertEmployee.php", employeeObj, (result) => {
                result += "";
                if (result == "result" || result == true) {
                    alert("เพิ่มข้อมูลพนักงานสำเร็จ!");
                    location.reload();
                }
            })
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
                <h5><strong>จัดการพนักงาน</strong></h5>
            </nav>
        </div>
        <div class="card-body">
            <form name="searchForm" id="searchForm">
                <div style="margin-bottom: 50px;" class="card">
                    <div class="card-header">ค้นหา</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>ชื่อ</label>
                                    <input class="form-control" id="search_emp_id" name="search_emp_id">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>ชื่อ</label>
                                    <input class="form-control" id="search_emp_name" name="search_emp_name">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>ตำแหน่ง</label>
                                    <select class="form-control" id="search_position_code"
                                            name="search_position_code">
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>แผนก</label>
                                    <select class="form-control" id="search_department_code"
                                            name="search_department_code">
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="btn-group">
                            <button class="btn btn-primary" type="button"><i class="fa fa-search"></i> ค้นหา</button>
                            <button class="btn btn-outline-success" type="button" data-toggle="modal" data-target="#addEmployeeModal">
                                <i class="fa fa-plus"></i> เพิ่ม
                                
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="card-header"><strong>รายการพนักงาน</strong></div>
                <div class="card-body" id="employeeList">
                </div>
            </div>
        </div>
        <div class="footer bg-warning text-white">

        </div>
    </div>
</div>


</body>
</html>


<div class="modal fade" id="addEmployeeModal" role="dialog" aria-labelledby="addEmployeeLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form name="addEmployeeForm" id="addEmployeeForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEmployeeLabel"><i class="fa fa-plus"></i> เพิ่มรายชื่อพนักงาน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>ชื่อ-สกุล</label>
                                                    <input name="emp_name" id="emp_name" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>รหัสบัตรประชาชน</label>
                                                    <input name="emp_card_id" id="emp_card_id" class="form-control"
                                                           required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label>เบอร์โทรศัพท์</label>
                                                    <input name="emp_tel" id="emp_tel" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>เพศ</label>
                                                    <select name="emp_gender" id="emp_gender" class="form-control"
                                                            required>
                                                        <option value="ชาย">ชาย</option>
                                                        <option value="หญิง">หญิง</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label>วันที่เริ่ม</label>
                                                    <input name="emp_start_date" id="emp_start_date"
                                                           class="form-control"
                                                           placeholder="ยังไม่ได้เลือกวันที่" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>เงินเดือน</label>
                                                    <input type="number" name="emp_salaly" id="emp_salaly"
                                                           class="form-control"
                                                           required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>ตำแหน่ง</label>
                                                    <select class="form-control" id="position_code"
                                                            name="position_code">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>แผนก</label>
                                                    <select class="form-control" id="department_code"
                                                            name="department_code">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>ที่อยู่</label>
                                                    <textarea name="emp_address" id="emp_address"
                                                              class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div align="center">
                                            <label>รูปภาพ</label>
                                            <img id="img-upload" src="img/icon/staff.png" width="200" border="5">
                                            <hr>
                                            <div class="btn-block">
                                                <button class="btn btn-sm btn-file btn-outline-info"><i
                                                            class="fa fa-image"></i> เลือกรูปภาพ
                                                    <input type="file" name="imgInp" id="imgInp"
                                                           required>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-block">
                        <button type="button" onclick="insertEmployee()" class="btn btn-primary"><i
                                    class="fa fa-save"></i> บันทึก
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

