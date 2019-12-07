<?php
session_start();
header('Access-Control-Allow-Origin: *');

$db_host = "localhost";
    $db_username = "root";
//    $db_password = "128345678";
    $db_password = "";
    $db_name = "punchtime";
    $conn = @mysqli_connect("$db_host", "$db_username", "$db_password", "$db_name");
    if (!$conn) {
        echo "Can't connect with MySQL" . mysqli_connect_errno() . "" . mysqli_connect_error();
    }
    mysqli_set_charset($conn, "utf8");
    date_default_timezone_set("Asia/Bangkok");
?>