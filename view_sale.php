<?php
include "mainpage.php";
$id=$_GET["id"];
if(isset($_GET["action"])&& $_GET["action"]=="view")
{
    $id=$_GET["id"];
    $data=$obj->GetAllRecords("select tbl_sale_dtl.* , tbl_item_mstr.name from tbl_item_mstr 
    join tbl_sale_dtl on tbl_sale_dtl.item_id=tbl_item_mstr.id where tbl_sale_dtl.status=1 and tbl_sale_dtl.sale_mstr_id=$id");
   // print_r($data);die;
   //$obj->Getlastquerypreview();die;
}
    $sale_dtl=$obj->GetRecord("select * from tbl_sale_mstr where status=1 and id=$id");
   // print_r($g_total);die;

?>
<div id="page-wrapper" >
    <div id="page-inner">
            <div class="col-md-12">
                <!-- <a href="purchasedtl.php" class=" btn btn-primary pull-right">Add New</a> -->
                <h3><u>View sale</u></h3>
                <div class="col-md-12">
                    <div class="col-md-3">
                    <label for="Receiving_no">Receiving No:</label>
                    <?php echo "#INV-".$sale_dtl["receiving_no"];?>
                    </div>
                    <div class="col-md-3">
                        <label for="receiving_date">Receiving Date:</label>
                        <?php echo $sale_dtl["receiving_date"];?>

                    </div>
                    <div class="col-md-3">
                        <label for="customer_name">Customer Name:</label>
                        <?php echo $sale_dtl["name"];?>
                    </div>
                    <div class="col-md-3">
                        <label for="mobile_no">Contact No:</label>
                        <?php echo $sale_dtl["mobile_no"];?>

                    </div>
                </div>
                <h3><u>Item Description</u></h3>
                <table class="table table-hovered">
                    <tr>
                        <th>#</th>
                        <th>Item:</th>
                        <th>Price:</th>
                        <th>Quantity:</th>
                        <th>Total</th>
                    </tr>
                    <?php
                    $i=0;
                    foreach ($data as $rec) 
                    {
                       // print_r($rec);die;
                        ?>
                        <tr>
                            <td><?php echo ++$i;?></td>
                            <td><?php echo $rec["name"];?></td>
                            <td><?php echo $rec["price"];?></td>
                            <td><?php echo $rec["quantity"];?></td>
                            <td><?php echo $rec["total"];?></td>

                        </tr>
                        <?php
                    }
                    ?>
                </table>
                </div>