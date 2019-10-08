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
                    alert("แก้ไขข้อมูลอุปกรณ์!");
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
                <h5><strong>รายงาน</strong></h5>
            </nav>
        </div>
        <div class="card-body">
            <div align="right">
            </div>
        </div>
        <div class="footer bg-warning text-white">

        </div>
    </div>
</div>
</body>

</html>
