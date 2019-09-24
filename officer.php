<?php
include '__connect.php';
include '__checkSession.php';
?>
<!Document>
<html>

<head>
    <?php include '__header.php'; ?>
    <script>

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
            <div style="margin-bottom: 50px;" class="card">
                <div class="card-header">ค้นหา</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>ชื่อ</label>
                                <input class="form-control"  id="emId" name="emId">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>ชื่อ</label>
                                <input class="form-control" id="emName" name="emName">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="btn-group">
                        <button class="btn btn-primary"><i class="fa fa-search"></i> ค้นหา</button>
                        <button class="btn btn-outline-success"><i class="fa fa-plus"></i> เพิ่ม</button>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><strong>รายการพนักงาน</strong></div>
                <div class="card-body" id="employeeList">
                    <div class="row" >
                        <div class="col-3">
                            <div class="card">
                                <div class="card-header"><strong>รหัส : xxxxx</strong></div>
                                <div class="card-body">
                                    <table class="table">
                                        <tr>
                                            <th>ชื่อ</th>
                                            <td>xxx</td>
                                        </tr>
                                        <tr>
                                            <th>เบอร์โทร</th>
                                            <td>xxx</td>
                                        </tr>
                                        <tr>
                                            <th>ตำแหน่ง</th>
                                            <td>xxx</td>
                                        </tr>
                                        <tr>
                                        </tr>
                                    </table>
                                </div>
                                <div class="card-footer">
                                        <button class="btn-block btn btn-outline-info">
                                            ดู/แก้ไข ข้อมูลพนักงาน
                                        </button>
                                </div>
                            </div>
                        </div>
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
