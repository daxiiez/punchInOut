<?php
include '../__connect.php';
if ($_POST) {
    $user = $_SESSION['username'];
    $content = $_POST['report_content'];
    $room = $_POST['room'];
    $tower = $_POST['tower'];
    $tel = $_POST['report_tel'];
    $type = $_POST['type'];
    $sql = "insert into report values(null,now(),'$content','$user','$room','$tower','N','$tel','$type')";
    $query = mysqli_query($conn, $sql);
    echo json_encode($query);
}

