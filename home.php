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
                <marquee>Test</marquee>
            </nav>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div align="center">
                        <a href="officer.php">
                            <div class="img-area" style="width: 400px;">
                                <img src="img/icon/staff.png" style="width: 400px;" class="image">
                                <div class="overlay bg-warning rounded">
                                    <div class="text">จัดการพนักงาน</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col">
                    <div align="center">
                        <a href="transaction.php">
                            <div class="img-area" style="width: 400px;">
                                <img src="img/icon/time.png" style="width: 400px;" class="image">
                                <div class="overlay  bg-primary rounded">
                                    <div class="text">เวลาเข้า-ออก</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col">
                    <div align="center">
                        <a href="device.php">
                            <div class="img-area" style="width: 400px;">
                                <img src="img/icon/beacon.png" style="width: 400px;" class="image">
                                <div class="overlay  bg-success rounded">
                                    <div class="text">อุปกรณ์</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col">
                    <div align="center">
                        <a href="department.php">
                            <div class="img-area" style="width: 400px;">
                                <img src="img/icon/department.png" style="width: 400px;" class="image">
                                <div class="overlay  bg-info rounded">
                                    <div class="text">แผนก</div>
                                </div>
                            </div>
                        </a>
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
