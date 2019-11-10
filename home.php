<?php
include '__connect.php';
include '__checkSession.php';
?>
<!Document>
<html>

<head>
    <?php include '__header.php'; ?>
    <script>
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

        $(document).ready(()=>{
            let currentDate = {
                date : new Date().getDate(),
                month : monthList[new Date().getMonth()],
                year : new Date().getFullYear()
            }
            console.log(currentDate);
            $("#alert").html("ระบบจัดการการเข้าออกของพนักงาน วันที่ "+currentDate.date+" "+currentDate.month.monthName+" "+currentDate.year);
        })
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
                <marquee id="alert"></marquee>
            </nav>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div align="center">
                        <a href="officer.php">
                            <div class="img-area" style="width: 200px;">
                                <img src="img/icon/staff.png" style="width: 200px;" class="image">
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
                            <div class="img-area" style="width: 200px;">
                                <img src="img/icon/time.png" style="width: 200px;" class="image">
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
                            <div class="img-area" style="width: 200px;">
                                <img src="img/icon/beacon.png" style="width: 200px;" class="image">
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
                            <div class="img-area" style="width: 200px;">
                                <img src="img/icon/department.png" style="width: 200px;" class="image">
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
