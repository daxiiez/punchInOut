<?php
include '../__connect.php';
$rent_id = $_POST['rent_id'];
$status = $_POST['status'];
if ($status == 'I' || $status == 'O') {
    if ($status == 'I') {
        $field = ",check_in_time = now()";
    } else {
        $field = ",check_out_time = now()";
    }
    $sql = "UPDATE rental_Detail set status = '$status' where rental_id = '$rent_id'";
} else {
    $sql = "UPDATE rental_Detail set status = '$status' where rental_id = '$rent_id'";
}

$result = mysqli_query($conn, $sql);


if ($status == 'S') {
    $sql = "SELECT * FROM rental_detail WHERE rental_id = '$rent_id'";
    $query = mysqli_query($conn, $sql);
    $rental = mysqli_fetch_assoc($query);
    $room_id = $rental['room_id'];
    $checkIn = $rental['check_in'];
    $checkOut = $rental['check_out'];
    $sql = "SELECT * FROM rental_detail where rental_id!='$rent_id' and room_id = '$room_id' and check_in between '$checkIn' and '$checkOut' and check_out between '$checkIn' and '$checkOut' ";
    $query2 = mysqli_query($conn, $sql);
    if ($query2) {
        while ($temp = mysqli_fetch_array($query2)) {
            $dupRental = $temp['rental_id'];
            $sql = "UPDATE rental_detail set status = 'C' where rental_id = '$dupRental' ";
            $queryDup = mysqli_query($conn, $sql);
        }
    }
}

echo $result;