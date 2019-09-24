<?php
include '__connect.php';
$address = '';
$tel = '';
$title = '';
$lineId = '';
$password = '';
$name = '';
$username = '';
$type = '';
$email = '';
$resultMsg = '';
$viewProfile = false;
if (isset($_POST['insertRegis'])) {
    if (isset($_POST['type'])) {
        $type = $_POST['type'];
    } else {
        $type = 'M';
    }
    $name = $_POST['name'];
    $address = $_POST['address'];
    $tel = $_POST['tel'];
    $lineId = $_POST['lineId'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $email = $_POST['emailProfile'];
    $title = $_POST['titleProfile'];
    $sql = "INSERT INTO rental.user (username, password, type, name, tel, address, line_id, email,title) 
VALUES ('$username', '$password', '$type', '$name', '$tel', '$address', '$lineId', '$email','$title')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        if (!isset($_SESSION['username'])) {
            $_SESSION['username'] = $username;
            $_SESSION['type'] = $type;
        }
        echo '<script>alert("สมัครสำเร็จ! ยินดีต้อนรับเข้าสู่ Rose Resort"); window.location = "index.php";</script>';
    } else {
        $resultMsg = '<div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                        <strong><i class="fa fa-times-circle"></i> เพิ่มข้อมูลไม่สำเร็จ!</strong> ชื่อผู้ใช้ซ้ำกรุณาหรอกใหม่
                    </div>';
    }
}
if (isset($_POST['updateProfile'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $tel = $_POST['tel'];
    $lineId = $_POST['lineId'];
    $username = $_POST['username'];
    $type = $_POST['type'];
    $email = $_POST['emailProfile'];
    $title = $_POST['titleProfile'];
    $sql = "UPDATE user set 
                            name = '$name',
                            address = '$address',
                            tel='$tel',
                            line_id='$lineId',
                            title='$title',
                            email = '$email'
                            where username = '$username'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $resultMsg = '<div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                               
                    <span aria-hidden="true">x ปิด</span>
                        </button>
                        <strong><i class="fa fa-check-circle"></i> สำเร็จ!</strong> แก้ไขข้อมูลเรียบร้อยแล้ว
                    </div>';
    } else {
        $resultMsg = '<div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              
                    <span aria-hidden="true">x ปิด</span>
                        </button>
                        <strong><i class="fa fa-times-circle"></i> แก้ไขข้อมูลไม่สำเร็จ!</strong> กรุณากรอกใหม่
                    </div>';
    }
}
if (isset($_GET['viewProfile'])) {
    $viewProfile = true;
    $username = $_SESSION['username'];
    $sql = "select * from user where username = '$username'";
    $query = mysqli_query($conn, $sql);
    $profile = mysqli_fetch_assoc($query);
    $tel = $profile['tel'];
    $lineId = $profile['line_id'];
    $address = $profile['address'];
    $password = $profile['password'];
    $name = $profile['name'];
    $username = $profile['username'];
    $type = $profile['type'];
    $title = $profile['title'];
    if ($email == '') {
        $email = $profile['email'];
    }
}
?>
<!Document>
<html>

<head>
    <?php include '__header.php'; ?>
    <script>
        $(document).ready(() => {
            $("#tel").mask("999-9999999");
        })
    </script>
</head>
<body>
<?php
include '__navbar_admin.php';
?>
<script>
    function checkPassword() {
        let pass = $("#password").val();
        let cpass = $("#cpassword").val();
        if (cpass != pass) {
            $("#cpassword").val("");
            $("#alertPass").html("*รหัสผ่านไม่ตรงกันกรุณากรอกใหม่อีกครั้ง");
        } else {
            $("#alertPass").html("");
        }
    }

    function setTitle(title) {
        $("#btn-title").html(title);
        $("#titleProfile").val(title);
    }
</script>
<div class="container-fluid" style="margin-top: 10px; margin-bottom: 150px;">
    <div class="card">
        <div class="card-header">
            <strong><i class="fa fa-users"></i> สมัครสมาชิก</strong>
        </div>
        <div class="card-body">
            <?php
            if ($resultMsg != '') {
                echo $resultMsg;
            }
            ?>
            <script>
                function checkUsername() {
                    let letterNumber = /^[0-9a-zA-Z]+$/;
                   let name =  $("#username").val();
                   if(!name.match(letterNumber)){
                       $("#username").val("")
                       alert("กรุณากรอก A-Z ด้วยตัวพิมพ์ใหญ่หรือพิมพ์เล็กเท่านั้น");
                   }
                }
            </script>
            <form id="regisForm" method="post">
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold">ชื่อผู้ใช้</label>
                                <input class="form-control" pattern="[A-Za-z0-9]{8,10}" name="username"
                                       placeholder="กรุณากรอกชื่อผู้ใช้ภาษาอังกฤษ 8 ตัวขึ้นไป"

                                       onchange="checkUsername()"
                                       id="username"
                                    <?php if ($viewProfile) {
                                        echo 'readonly ';
                                        echo 'value="' . $username . '"';
                                    } ?>
                                       required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold">ชื่อ-สกุล</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-info dropdown-toggle" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                         <span id="btn-title">
                                             <?php
                                             if ($title != '') {
                                                 echo $title;
                                             } else {
                                                 echo 'นาย';
                                             }
                                             ?>
                                             </span>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" onclick="setTitle('นาย')">นาย</a>
                                            <a class="dropdown-item" onclick="setTitle('นาง')">นาง</a>
                                            <a class="dropdown-item" onclick="setTitle('นางสาว')">นางสาว</a>
                                        </div>
                                    </div>
                                    <input type="hidden" name="titleProfile" id="titleProfile" value="<?php
                                    if ($title != '') {
                                        echo $title;
                                    } else {
                                        echo 'นาย';
                                    }
                                    ?>">

                                    <input class="form-control" name="name" id="name"
                                           pattern="[\s\S]{8,100}$"
                                           placeholder="กรุณากรอกชื่อภาษาไทย 8 ตัวขึ้นไป"
                                        <?php if ($viewProfile) {
                                            echo 'value="' . $name . '"';
                                        } ?>
                                           required>
                                </div>
                            </div>
                        </div>
                        <?php if (!$viewProfile) {
                            ?>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">รหัสผ่าน</label>
                                    <input type="password" pattern="[\s\S]{8,100}$" class="form-control" name="password" id="password"
                                           placeholder="กรุณากรอกรหัสผ่าน 8 ตัวขึ้นไป"
                                           required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">ยืนยันรหัสผ่าน</label>
                                    <input type="password" pattern="[\s\S]{8,10}$" onchange="checkPassword()" class="form-control"
                                           placeholder="กรุณากรอกรหัสผ่าน 8 ตัวขึ้นไป"
                                           name="cpassword"
                                           id="cpassword" required>
                                    <small class="text-danger" id="alertPass"></small>
                                </div>
                            </div>
                            <?php
                        } ?>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold">โทรศัพท์</label>
                                <input class="form-control" pattern="[\s\S]{11}$" name="tel" id="tel"
                                       placeholder="กรุณากรอกเบอร์ 10 หลัก 0xx-xxxxxxx"
                                    <?php if ($viewProfile) {
                                        echo 'value="' . $tel . '"';
                                    } ?>
                                       required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold">ไลน์ไอดี</label>
                                <input class="form-control" name="lineId" id="lineId"
                                    <?php if ($viewProfile) {
                                        echo 'value="' . $lineId . '"';
                                    } ?>
                                >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold">อีเมล</label>
                                <input class="form-control" type="email" placeholder="กรุณากรอก email เช่น emailname@website.com"
                                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="emailProfile"
                                       id="emailProfile"
                                    <?php if ($viewProfile) {
                                        echo 'value="' . $email . '"';
                                    } ?>
                                >
                            </div>
                        </div>
                        <div class="col-6"></div>
                        <?php

                        if (isset($_SESSION['username'])) {
                            ?>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">ประเภทผู้ใช้ระบบ</label>
                                    <select class="form-control" name="type" id="type">
                                        <?php if ($_SESSION['type'] == 'A') { ?>
                                            <option value="A">เจ้าของ</option>
                                            <option value="C">แคชเชียร์</option>
                                        <?php } ?>
                                        <option value="M" selected>ลูกค้า</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6"></div>
                            <?php
                        } ?>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Address</label>
                                <textarea class="form-control" name="address"
                                          placeholder="กรุณากรอกที่อยู่ จังหวัด อำเภอ ตำบล หมู่บ้าน เลขที่ รหัสไปรษณีย์ ให้ชัดเจน"
                                          id="address"
                                          required><?php if ($viewProfile) {
                                        echo $address;
                                    } ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div align="center">
                        <?php if ($viewProfile) { ?>
                            <button type="submit" name="updateProfile" class="btn btn-primary"><i
                                        class="fa fa-edit"></i> แก้ไข Profile
                            </button><?php } else { ?>
                            <button type="submit" name="insertRegis" class="btn btn-primary"><i
                                        class="fa fa-check-circle"></i> ยืนยันการสมัคร
                            </button><?php } ?>
                    </div>
                </div>
            </form>
        </div>
        <div class="footer bg-warning text-white">

        </div>
    </div>
</div>
</body>
</html>