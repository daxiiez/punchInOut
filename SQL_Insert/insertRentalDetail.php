<?php
include '../__connect.php';
if ($_POST) {
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
    } else {
        $username = $_SESSION['username'];
    }
    $room_id = $_POST['roomId'];
    $rent_days = $_POST['totalDate'];
    $check_in = $_POST['startDate'];
    $check_out = $_POST['endDate'];
    $rent_cost = $_POST['totalCost'];
    $deposit = $_POST['deposit'];
    $sql = "INSERT INTO rental.rental_detail (rental_id, rent_date, room_id, username, rent_days, check_in, check_out, rent_cost, deposit, status, pay_img,check_out_status,check_in_time,check_out_time)
 select ifnull(LPAD(CAST(max(rental_id) + 1 AS SIGNED), 10, '0') ,LPAD('1', 10, '0')),
  now(),
   '$room_id',
    '$username',
     $rent_days,  
     STR_TO_DATE('$check_in','%d-%c-%Y'),
      STR_TO_DATE('$check_out','%d-%c-%Y'),
       $rent_cost,
        $deposit,
         'N',
          '0x',
          'N',
          '13:00:00',
          '12:00:00'
           from rental_detail";
    $_SESSION['reserveStatus'] = 'N';
    $query = mysqli_query($conn, $sql);
    echo json_encode($query);
}

