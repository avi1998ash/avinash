<?php
include "mainpage.php";
if(isset($_POST["item_id"]))
{
    $item_id=$_POST["item_id"];
    $purchase=$obj->GetRecord("select sum(quantity) as p_qty from tbl_purchase_dtl where status=1 and item_id=$item_id group by item_id");
    $p=$purchase["p_qty"];
    //print_r($p);die;
    $sale=$obj->GetRecord("select sum(quantity) as s_qty from tbl_sale_dtl where status=1 and item_id=$item_id group by item_id");
    $s=$sale["s_qty"];
    echo $a=$p-$s;
    //print_r($a);
    //$obj->Getlastquerypreview();

   // echo json_encode($a);
}
?>