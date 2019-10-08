<?php
include '__connect.php';
include '__checkSession.php';
?>
<!Document>
<html>

<head>
    <?php include '__header.php'; ?>
    <script>
        let deviceList;
        $(document).ready(() => {
            /*$("#update_major").mask("99");
            $("#insert_minor").mask("999999999999");
            $("#update_major").mask("99");
            $("#insert_minor").mask("999999999999");*/
            getDeviceList();
        });

        function getDeviceList() {
            $.get("SQL_Select/selectDevice.php", null, (r) => {
                deviceList = JSON.parse(r);

                let txt = "<table class='table table-bordered '>";
                txt += "<tr class='bg-info text-white'>";
                txt += "    <th>#</th>";
                txt += "    <th>UUID</th>";
                txt += "    <th>Major</th>";
                txt += "    <th>Minor</th>";
                txt += "    <th>ชื่ออุปกรณ์</th>";
                txt += "    <th>สถานะ</th>";
                txt += "    <th>แก้ไข</th>";
                txt += "<tr>";
                deviceList.forEach((f, i) => {
                    txt += "<tr>";
                    txt += "    <td>" + (i + 1) + "</td>";
                    txt += "    <td>" + f.uuid + "</td>";
                    txt += "    <td>" + f.major + "</td>";
                    txt += "    <td>" + f.minor + "</td>";
                    txt += "    <td>" + f.device_name + "</td>";
                    txt += "    <td>" + f.status + "</td>";
                    txt += "    <td>" +
                        "<div class='btn-group'> " +
                        "<button onclick='editDetail(" + '"' + f.uuid + '"' + ")' class='btn btn-primary'><i class='fa fa-edit'></i> แก้ไข</button>" +
                        "<button onclick='deleteDetail(" + '"' + f.uuid + '"' + ")' class='btn btn-outline-danger'><i class='fa fa-trash'></i> ลบ</button>" +
                        "</div>" +
                        "</td>";
                    txt += "<tr>";
                });
                txt += "</table>";
                $("#deviceArea").html(txt);
            });
        }

        function deleteDetail(uuid) {
            let obj = {
                uuid : uuid
            }
            if (confirm("ต้องการลบอุปกณ์ " + uuid + " หรือไม่ ?")) {
                $.post("SQL_Delete/deleteDevice.php", obj, (result) => {
                    if (result == "result" || result == true) {
                        alert("ลบข้อมูลสำเร็จ!");
                        getDeviceList()
                    }
                });
            }
        }

        function validateFrom(obj) {
            console.log(obj);
            for (let i in obj) {
                if (!obj[i]) return false;
            }
            return true;
        }

        function editDetail(uuid) {
            let em = deviceList.filter(f => f.uuid == uuid)[0];
            _.mapValues(em, (v, k) => {
                try {
                    $("#update_" + k).val(v);
                } catch (e) {
                }
            });

            $('#updateDeviceModal').modal('toggle');
        }

        function insertDevice() {
            console.log("Insert Device");
            let deviceObj = arrayToObject($("#addDeviceForm").serializeArray());
            if (validateFrom(deviceObj)) {
                $.post("SQL_Insert/insertDevice.php", deviceObj, (result) => {
                    if (result == "result" || result == true) {
                        alert("เพิ่มข้อมูลอุปกรณ์สำเร็จ!");
                        location.reload();
                    }
                });
            } else {
                alert("กรุณากรอกข้อมูลให้ครบถ้วน")
            }
        }

        function updateDevice() {
            let updateObj = arrayToObject($("#updateDeviceForm").serializeArray());
            console.log(updateObj);
            $.post("SQL_Update/updateDevice.php", updateObj, (result) => {
                if (result == "result" || result == true) {
                    alert("แก้ไขข้อมูลอุปกรณ์สำเร็จ!");
                    getDeviceList()
                }
            });
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
                        data-target="#addDeviceModal">
                    <i class="fa fa-plus"></i> เพิ่มอุปกรณ์
                </button>
                <br>
            </div>

            <div id="deviceArea">

            </div>
        </div>
        <div class="footer bg-warning text-white">

        </div>
    </div>
</div>
</body>


<div class="modal fade" id="addDeviceModal" role="dialog" aria-labelledby="addDeviceLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form name="addDeviceForm" id="addDeviceForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDeviceLabel"><i class="fa fa-plus"></i> เพิ่มรายชื่อพนักงาน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>UUID</label>
                                        <input name="insert_uuid" id="insert_uuid" class="form-control" maxlength="40">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Major</label>
                                        <input name="insert_major" id="insert_major" class="form-control" maxlength="2">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Minor</label>
                                        <input name="insert_minor" id="insert_minor" class="form-control" maxlength="12">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>ชื่ออุปกรณ์</label>
                                        <input name="insert_device_name" id="insert_device_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>สถานะ</label>
                                        <select name="insert_status" id="insert_status" class="form-control">
                                            <option value="A">Active</option>
                                            <option value="C">Cancel</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-block">
                        <button type="button" onclick="insertDevice()" class="btn btn-primary"><i
                                    class="fa fa-save"></i> บันทึก
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="updateDeviceModal" role="dialog" aria-labelledby="updateDeviceModal"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="updateDeviceForm" id="updateDeviceForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateDeviceLabel"><i class="fa fa-edit"></i> แก้ไขข้อมูลอุปกรณ์</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>UUID</label>
                                    <input name="update_uuid" id="update_uuid" class="form-control" maxlength="40">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Major</label>
                                    <input name="update_major" id="update_major" class="form-control" maxlength="2">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Minor</label>
                                    <input name="update_minor" id="update_minor" class="form-control" maxlength="12">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>ชื่ออุปกรณ์</label>
                                    <input name="update_device_name" id="update_device_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>สถานะ</label>
                                    <select name="update_status" id="update_status" class="form-control">
                                        <option value="A">Active</option>
                                        <option value="C">Cancel</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-block">
                        <button type="button" onclick="updateDevice()" class="btn btn-primary"><i
                                    class="fa fa-save"></i> บันทึก
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</html>
