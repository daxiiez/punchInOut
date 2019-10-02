<?php
include '__connect.php';
?>
<?php
$msg = "";

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $username =  $row['username'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['type'] = $row['type'];
        $sql = "SELECT * FROM rental_detail WHERE username ='$username' order by rental_id desc";
        $query = mysqli_query($conn,$sql);
        $rental = mysqli_fetch_array($query);
        echo "<script> alert('เข้าสู่ระบบสำเร็จ'); window.location='index.php'; </script>";
    } else {
        $msg = "<span class='text-danger'><i class='fa fa-times'></i> เข้าสู่ระบบไม่สำเร็จ กรุณาตรวจสอบ username/password อีกครั้ง</span>";
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
                            <input type="text" name="username" class="form-control" placeholder="" aria-label=""
                                   aria-describedby="basic-addon1">
                        </div>

                        <br>

                        <div class="form-group" align="left">
                            <label  class="font-weight-bold"> รหัสผ่าน</label>
                            <input type="password" name="password" class="form-control" placeholder="" aria-label=""
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
