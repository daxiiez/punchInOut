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
        $username = $row['emp_username'];
        $_SESSION['emp_username'] = $row['emp_username'];
        $sql = "SELECT * FROM rental_detail WHERE username ='$username' order by rental_id desc";
        $query = mysqli_query($conn, $sql);
        $rental = mysqli_fetch_array($query);
        $_SESSION['reserveStatus'] = $rental['status'];
        echo "<script> alert('เข้าสู่ระบบสำเร็จ'); window.location='home.php'; </script>";
    } else {
        $msg = "<span class='text-danger'><i class='fa fa-times'></i> เข้าสู่ระบบไม่สำเร็จ กรุณาตรวจสอบ username/password อีกครั้ง</span>";
    }
}else{
    if(isset($_SESSION['emp_username'])){
        header("Location: home.php");
    }
}
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

<div class="container" style="margin-top: 10px; margin-bottom: 150px;">
    <div class="card">
        <div class="card-header">
            <nav aria-label="breadcrumb  bg-dark">
                <h5 class="font-weight-bold">เข้าสู่ระบบ</h5>
            </nav>
        </div>
        <div class="card-body">
            <div class="container">
                <form method="post">
                    <div class="card-body">
                        <div class="form-group" align="left">
                            <label class="font-weight-bold"> ชื่อผู้ใช้</label>
                            <input type="text" name="emp_username" class="form-control" placeholder="" aria-label=""
                                   aria-describedby="basic-addon1">
                        </div>
                        <br>
                        <div class="form-group" align="left">
                            <label class="font-weight-bold"> รหัสผ่าน</label>
                            <input type="password" name="emp_password" class="form-control" placeholder="" aria-label=""
                                   aria-describedby="basic-addon1">
                            <?php echo $msg; ?>
                        </div>
                        <br>
                        <button class="btn btn-info" type="submit"><i class="fa fa-sign-in"></i> เข้าสู่ระบบ</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="footer bg-warning text-white">

        </div>
    </div>
</div>
</body>
</html>
