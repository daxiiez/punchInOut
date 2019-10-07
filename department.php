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
        let punchTimeList;
        $(document).ready(() => {
            getDepartmentList();
        });

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
                if (!obj[i]) return false;
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
            let name = departmentList.filter((f) => f.department_code == department_code)[0].name

            $("#departmentPunchTimeHeader").html("เวลาเข้างานของแผนก" + name);

            let searchObj = {
                department_code: department_code
            };

            $.get("SQL_Select/selectPunchTimeDepartment.php", searchObj, (r) => {
                    r = JSON.parse(r);
                    let html = "";
                    punchTimeList = r.map((m) => {
                        let v = m;
                        v.effective_date = new Date(m.effective_date);
                        return v;
                    });
                }
            );

            $("#punchTimeSettingModal").modal('toggle');
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
                <h5><strong>อุปกรณ์</strong></h5>
            </nav>
        </div>
        <div class="card-body">
            <div align="right">
                <button class="btn btn-outline-success" type="button" data-toggle="modal"
                        data-target="#addDepartmentModal">
                    <i class="fa fa-plus"></i> เพิ่มอุปกรณ์
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
</body>


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
                <div class="modal-content">

                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

</html>
