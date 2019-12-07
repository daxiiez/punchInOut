<?php
include '__connect.php';
?>
<?php
$msg = "";
if (isset($_POST['emp_username'])) {
    $username = $_POST['emp_username'];
    $password = $_POST['emp_password'];
    $sql = "SELECT * FROM employee WHERE emp_username='$username' AND emp_password='$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        if ($row['emp_typeuser'] != '1') {
            header("Location: noAuth.php");
            session_destroy();
        }
        $username = $row['emp_username'];
        $_SESSION['emp_typeuser'] = 'Y';
        $_SESSION['emp_username'] = $row['emp_username'];
        echo "<script>  window.location='home.php'; </script>";
    } else {
        $msg = "<span class='text-danger'><i class='fa fa-times'></i> เข้าสู่ระบบไม่สำเร็จ กรุณาตรวจสอบ username/password อีกครั้ง</span>";
    }
} else {
    if (isset($_SESSION['emp_username'])) {
        header("Location: home.php");
    }
}
?>
<!Document>
<html>
<style>
    /*@font-face {*/
    /*    font-family: headers;font-family: headers;*/
    /*    src: url("font/Serithai-Regular.ttf");*/
    /*}*/



    .content:before {
        content: "";
        position: fixed;
        left: 0;
        right: 0;
        z-index: -1;

        display: block;
        background-image: url('img/img1.jpg');
        background-size:cover;
        width: 100%;
        height: 100%;

/*        -webkit-filter: blur(2px);
        -moz-filter: blur(2px);
        -o-filter: blur(2px);
        -ms-filter: blur(2px);
        filter: blur(2px);*/
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }

</style>
<head>
    <?php include '__header.php'; ?>
    <script>
    </script>
</head>
<body class="content">
<?php
//include '__navbar_admin.php';
?>
<style>
    *{
        font-family: applyFont2;
    }

</style>
<div class="container" style=" ">
    <div class="container">
        <div align="center">
            <br>
            <br>
            <h1 class="font-weight-bold logo">Time AD</h1>
            <img src="img/push_back_time.png" style="width: 20%">

        </div>
    </div>
    <div class="row" style="zoom: 0.8">
        <div class="col"></div>
        <div class="col">
            <div class="card rounded">
                <div class="card-header">
                    <nav aria-label="breadcrumb  bg-dark">
                        <h5 class="font-weight-bold">เข้าสู่ระบบ</h5>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="container">
                        <form method="post" >
                            <div class="card-body">
                                <div class="form-group" align="left">
                                    <label class="font-weight-bold"> ชื่อผู้ใช้</label>
                                    <input type="text" name="emp_username" class="form-control" placeholder=""
                                           aria-label=""
                                           aria-describedby="basic-addon1">
                                </div>
                                <br>
                                <div class="form-group" align="left">
                                    <label class="font-weight-bold"> รหัสผ่าน</label>
                                    <input type="password" name="emp_password" class="form-control" placeholder=""
                                           aria-label=""
                                           aria-describedby="basic-addon1">
                                    <?php echo $msg; ?>
                                </div>
                                <br>
                                <button class="btn btn-info" type="submit"><i class="fa fa-sign-in"></i> เข้าสู่ระบบ
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="footer bg-warning text-white">

                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>
</div>
</body>
</html>
