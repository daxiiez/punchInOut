<?php
include '../connect.php';
if ($_POST) {

    $sql = "SELECT import_no FROM import_detail ORDER BY import_no DESC LIMIT 1";
    $result = mysqli_query($conn,$sql);
    $content = mysqli_fetch_assoc($result);
    $import_no = '';
    $import_no = $content['import_no'];
    $import_no = substr($import_no,0,1).sprintf('%09d',((int)substr($import_no,-1)+1));

    $import_date       = $_POST['importDate'];
    $supplier_id               = $_POST['supplierId'];
    $totalProductCost            = $_POST['totalProductCost'];
    $sql = "insert into import_detail values ('$import_no',
                                                STR_TO_DATE('$import_date','%d/%c/%Y'),
                                                '$supplier_id',
                                                '$totalProductCost')";

    $resultInsert = mysqli_query($conn,$sql);
    if($resultInsert){
        $max = count($_POST['productList']);
        for($i=0;$i<$max;$i++){
            $import_no = $import_no;
            $product_id = $_POST['productList'][$i]['id'];
            $qty = $_POST['productList'][$i]['qty'];
            $cost = $_POST['productList'][$i]['purchaseCost'];
            $sql = "INSERT INTO import_list values('$import_no','$product_id','$qty','$cost')";
            $resultImport = mysqli_query($conn,$sql);
            if($resultImport){
                $sql = "UPDATE PRODUCT SET stock = stock + $qty where id = '$product_id'";
                $resultProduct = mysqli_query($conn,$sql);
            }
        }
    }

    if($resultInsert && $resultProduct){
        $json = (object)'';
        $json->import_no = $import_no;

        echo json_encode($json);
    }else{
        echo false;
    }
}

