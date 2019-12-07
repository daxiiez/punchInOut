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
        let imgUploadFile;
        let updateEmpId;

        $(document).ready(() => {
            hideSearch();
            $("#emp_card_id").mask("9999999999999");
            $("#emp_tel").mask("9999999999");
            $("#emp_salaly").mask("999999");
            $("#update_emp_salaly").mask("99999");
            $("#emp_tel").mask("9999999999");
            $("#update_emp_card_id").mask("9999999999999");
            $("#update_emp_tel").mask("9999999999");
            setDatePicker();
            getDepartmentList();
            // getPositionList();
            setTimeout(() => {
                getOfficerList(false);
            }, 1000);

            function readURL(input, id) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        imgFile = e.target.result.replace(/^data:image\/[a-z]+;base64,/, "");
                        imgUploadFile = e.target.result.replace(/^data:image\/[a-z]+;base64,/, "");
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

            $("#update_imgInp").change(function () {
                readURL(this, '#update_img-upload');
            });
        });

        function setDatePicker() {
            $('#emp_start_date').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'dd/mm/yyyy'
            });
        };

        function validateFrom(obj) {
            console.log(obj);
            for (let i in obj) {
                if (!obj[i]) return false;
            }
            return true;
        }

        function getDepartmentList() {
            $.get("SQL_Select/selectDepartment.php", null, (data) => {
                departmentList = JSON.parse(data);
                let departmentListTxt = "";
                departmentList.forEach(f => {
                    departmentListTxt += "<option value='" + f.department_code + "'>" + f.name + "</option>"
                })
                $("#department_code").html(departmentListTxt);
                $("#update_department_code").html(departmentListTxt);
                departmentListTxt = "<option value=''>-- เลือกตำแหน่ง --</option>" + departmentListTxt;
                $("#search_department_code").html(departmentListTxt);
            });
        };

        function getOfficerList(isSearch) {
            let searchCriteria = null;
            if (isSearch) {
                searchCriteria = arrayToObject($("#searchForm").serializeArray().map((m) => {
                    let v = m;
                    v.value = v.value.trim();
                    return v;
                }));
                searchCriteria["search"] = true;
            }
            $.get("SQL_Select/selectEmployee.php", searchCriteria, (data) => {
                employeeList = JSON.parse(data);
                if (employeeList) {
                    setEmployeeList();
                } else {
                    alert("ไม่พบข้อมูล");
                }
            });
        };

        function setEmployeeList() {
            let html = "<thead>" +
                " <tr class='bg-info text-white'>\n" +
                "                            <th>รหัส</th>\n" +
                "                            <th>ชื่อ</th>\n" +
                "                            <th>เบอร์โทรศัพท์</th>\n" +
                "                            <th>สิทธิ์การใช้งาน</th>\n" +
                "                            <th>แผนก</th>\n" +
                "                            <th>แก้ไข</th>\n" +
                "                        </tr >" +
                "                        </thead>";
            employeeList.forEach(f => {
                // let positionName = positionList.filter(x => f.position_code == x.position_code)[0].name;
                let departmentName = departmentList.filter(x => f.department_code == x.department_code)[0].name;
                let statusLabel = '';
                if (f.emp_typeuser == '1') {
                    statusLabel = "<p class='text-center text-success'><i class='fa fa-check'></i></p>"
                } else {
                    statusLabel = "<p class='text-center text-danger'><i class='fa fa-times'></i></p>"
                }
                html += " <tr> " +
                    "                                            <td>" + f.emp_id + "</td>" +
                    "                                            <td>" + f.emp_name + "</td>" +
                    "                                            <td>" + f.emp_tel + "</td>" +
                    "                                            <td>" + statusLabel + "</td>" +
                    "                                            <td>" + departmentName + "</td>" +
                    "                                            <td>" +
                    "                                    <button type='button' onclick='viewEmployeeDetail(" + f.emp_id + ")' class='btn-block btn btn-outline-info'>" +
                    "                                        ดู/แก้ไข ข้อมูลพนักงาน" +
                    "                                    </button>" +
                    "</td>" +
                    "                                        </tr>";
            });
            $("#employeeList").html(html);
            $('#employeeList').DataTable();
        };

        function viewEmployeeDetail(emp_id) {
            let em = employeeList.filter(f => f.emp_id == emp_id)[0];
            updateEmpId = emp_id;
            let img = "";
            _.mapValues(em, (v, k) => {
                try {
                    $("#update_" + k).val(v);
                    if (k == "emp_pic") {
                        imgUploadFile = v;
                        img = "<img id='update_img-upload' src='data:image/jpeg;base64," + v + "' width='50%'>";
                        $("#imgAreaUpload").html(img);
                    }
                } catch (e) {
                }
            });
            console.log(em)
            let checked = em.emp_typeuser == '1' ? true : false;
            $("#update_emp_typeuser").prop('checked', checked);

            if (checked) {
                $("#update_emp_typeuser").attr("disabled", true);
            } else {
                $("#update_emp_typeuser").removeAttr("disabled");
            }
            $('#updateEmployeeModal').modal('toggle');
        }

        function insertEmployee() {
            console.log("Insert Employee");
            let employeeObj = arrayToObject($("#addEmployeeForm").serializeArray());
            employeeObj["emp_pic"] = imgFile;
            if (validateFrom(employeeObj)) {
                $.post("SQL_Insert/insertEmployee.php", employeeObj, (result) => {
                    if (result == "result" || result == true) {
                        alert("เพิ่มข้อมูลพนักงานสำเร็จ!");
                        location.reload();
                    }
                });
            } else {
                alert("กรุณากรอกข้อมูลให้ครบถ้วน")
            }
        }

        function deleteEmployee() {
            let empID = $("#update_emp_id").val();
            if (confirm("ต้องการที่จะลบพนักงานหรือไม่ ?")) {
                $.post("SQL_Delete/deleteEmployee.php", {emp_id: empID}, (result) => {
                    if (result == "result" || result == true) {
                        alert("แก้ไขข้อมูลพนักกงานสำเร็จ!");
                        location.reload();
                    }
                });
            }
        }

        function updateEmployee() {
            let userType = $("#update_emp_typeuser")[0].checked ? '1' : '0';
            let updateObj = arrayToObject($("#updateEmployeeForm").serializeArray());
            updateObj["update_emp_pic"] = imgUploadFile;
            updateObj["update_emp_id"] = updateEmpId;
            updateObj["update_emp_typeuser"] = userType;
            $.post("SQL_Update/updateEmployee.php", updateObj, (result) => {
                if (result == "result" || result == true) {
                    alert("แก้ไขข้อมูลพนักกงานสำเร็จ!");
                    getOfficerList()
                }
            });
        }

        function validateEmpUsername(id) {
            let eleId = "#"+id;
            let empUsername = $(eleId).val();
            $.get("SQL_Select/validateEmpUsername.php", {emp_username: empUsername}, (r) => {
                let result = JSON.parse(r);
                if (result.length > 0) {
                    alert("ชื่อผู้ใช้พนักงานซ้ำ! กรุณาระบุชื่อผู้ใช้ใหม่");
                    $(eleId).val("");
                }
            });
        }

        function validateEmpId() {
            let empId = $("#emp_id").val();
            $.get("SQL_Select/validateEmpId.php", {emp_id: empId}, (r) => {
                let result = JSON.parse(r);
                if (result.length > 0) {
                    alert("รหัสพนักงานซ้ำ! กรุณาระบุรหัสพนักงานใหม่");
                    $("#emp_id").val("");
                }
            });

        }

        function hideSearch() {
            $("#searchForm").hide();
        }

        function showSearch() {
            $("#searchForm").show();
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
                <h5>
                    <strong>จัดการพนักงาน</strong>
                </h5>
            </nav>
        </div>
        <div class="card-body" id="searchArea">
            <form name="searchForm" id="searchForm">
                <div style="margin-bottom: 50px;" class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <strong>ค้นหา</strong>
                            </div>
                            <div class="col-6">
                                <div align="right">
                                    <span onclick="hideSearch()" style="cursor: pointer;"><strong>X</strong> ซ่อนการค้นหา</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>รหัส</label>
                                    <input class="form-control" id="search_emp_id" name="search_emp_id">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>ชื่อ</label>
                                    <input class="form-control" id="search_emp_name" name="search_emp_name">
                                </div>
                            </div>
                            <!-- <div class="col">
                                 <div class="form-group">
                                     <label>ตำแหน่ง</label>
                                     <select class="form-control" id="search_position_code"
                                             name="search_position_code">
                                     </select>
                                 </div>
                             </div>-->
                            <div class="col">
                                <div class="form-group">
                                    <label>แผนก</label>
                                    <select class="form-control" id="search_department_code"
                                            name="search_department_code">
                                    </select>
                                </div>
                            </div
                        </div>

                    </div>
                </div>
                <div class="card-footer">
                    <div class="btn-group">
                        <button class="btn btn-primary" onclick="getOfficerList(true)" type="button"><i
                                    class="fa fa-search"></i> ค้นหา
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <strong>รายการพนักงาน</strong>
                    </div>
                </div>


            </div>
            <div class="card-body">
                <div align="right">
                    <!-- <button class="btn btn-outline-primary" type="button" onclick="showSearch()">
                         <i class="fa fa-search"></i> ค้นหาพนักงาน
                     </button>-->
                    <button class="btn btn-outline-success" type="button" data-toggle="modal"
                            data-target="#addEmployeeModal">
                        <i class="fa fa-plus"></i> เพิ่มพนักงาน
                    </button>
                </div>
                <hr>
                <table class="table table-bordered" id="employeeList">

                    <tr>

                    </tr>
                </table>
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
                    <h5 class="modal-title" id="addEmployeeLabel"><i class="fa fa-plus"></i>
                        <strong>เพิ่มรายชื่อพนักงาน</strong>

                    </h5>
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
                                                    <label>รหัสพนักงาน</label>
                                                    <input name="emp_id" id="emp_id" type="number" maxlength="10"
                                                           onchange="validateEmpId()" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input name="emp_username" id="emp_username"
                                                           onchange="validateEmpUsername('emp_username')" class="form-control"
                                                           maxlength="20" required>
                                                </div>
                                            </div>
                                        </div>
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
                                                    <input name="emp_start_date"
                                                           id="emp_start_date"
                                                           class="form-control"
                                                           readonly
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
                                            <!--<div class="col-6">
                                                <div class="form-group">
                                                    <label>ตำแหน่ง</label>
                                                    <select class="form-control" id="position_code"
                                                            name="position_code">
                                                    </select>
                                                </div>
                                            </div>-->
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
                                            <div id="imgArea">
                                                <img id="img-upload" src="img/icon/staff.png" width="200" border="5">
                                            </div>
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
<div class="modal fade" id="updateEmployeeModal" role="dialog" aria-labelledby="updateEmployeeModal"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="updateEmployeeForm" id="updateEmployeeForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateEmployeeLabel"><i class="fa fa-edit"></i> <strong>แก้ไขรายชื่อพนักงาน</strong>
                    </h5>
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
                                                    <label>รหัสพนักงาน</label>
                                                    <input name="update_emp_id" id="update_emp_id"
                                                           class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input name="update_emp_username" id="update_emp_username"
                                                           onchange="validateEmpUsername('update_emp_username')"
                                                           class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>ชื่อ-สกุล</label>
                                                    <input name="update_emp_name" id="update_emp_name"
                                                           class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>รหัสบัตรประชาชน</label>
                                                    <input name="update_emp_card_id" id="update_emp_card_id"
                                                           class="form-control"
                                                           required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label>เบอร์โทรศัพท์</label>
                                                    <input name="update_emp_tel" id="update_emp_tel"
                                                           class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>เพศ</label>
                                                    <select name="update_emp_gender" id="update_emp_gender"
                                                            class="form-control"
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
                                                    <input name="update_emp_start_date" id="update_emp_start_date"
                                                           class="form-control"
                                                           readonly
                                                           placeholder="ยังไม่ได้เลือกวันที่" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>เงินเดือน</label>
                                                    <input type="number" name="update_emp_salaly" id="update_emp_salaly"
                                                           class="form-control"
                                                           required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>แผนก</label>
                                                    <select class="form-control" id="update_department_code"
                                                            name="update_department_code">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>ตำแหน่ง</label>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" id="update_emp_typeuser"
                                                                      name="update_emp_typeuser" value=""> สถานะ
                                                            Admin</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>ที่อยู่</label>
                                                    <textarea name="update_emp_address" id="update_emp_address"
                                                              class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div align="center">
                                            <label>รูปภาพ</label>
                                            <div id="imgAreaUpload">
                                                <img id="update_img-upload" src="img/icon/staff.png" width="200"
                                                     border="5">
                                            </div>
                                            <hr>
                                            <div class="btn-block">
                                                <button class="btn btn-sm btn-file btn-outline-info"><i
                                                            class="fa fa-image"></i> เลือกรูปภาพ
                                                    <input type="file" name="update_imgInp" id="update_imgInp"
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
                        <button type="button" onclick="deleteEmployee()" class="btn btn-danger"><i
                                    class="fa fa-trash"></i> ลบพนักงาน
                        </button>
                        <button type="button" onclick="updateEmployee()" class="btn btn-primary"><i
                                    class="fa fa-save"></i> บันทึก
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

