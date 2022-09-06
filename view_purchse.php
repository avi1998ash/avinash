<?php
include "header.php";
$id=$_GET["id"];
print_r($id);die;
if(isset($_GET["action"])&& $_GET["action"]=="view")
{
    $id=$_GET["id"];
    $data=$obj->GetAllRecords("select tbl_purchase_dtl.* , tbl_item_mstr.name from tbl_item_mstr 
    join tbl_purchase_dtl on tbl_purchase_dtl.item_id=tbl_item_mstr.id where tbl_purchase_dtl.status=1 and tbl_purchase_dtl.purchase_id=$id");
   // print_r($data);die;
   $obj->Getlastquerypreview();die;
}
    $purchase_dtl=$obj->GetRecord("select * from tbl_purchase_mstr where status=1 and id=$id");
   // print_r($g_total);die;

?>
<div id="page-wrapper" >
    <div id="page-inner">
            <div class="col-md-12">
                <!-- <a href="purchasedtl.php" class=" btn btn-primary pull-right">Add New</a> -->
                <h3><u>View Purchase</u></h3>
                <div class="col-md-12">
                    <div class="col-md-3">
                    <label for="Receiving_no">Invoice No:</label>
                    <?php echo "#INV-".$purchase_dtl["invoice_no"];?>
                    </div>
                    <div class="col-md-3">
                        <label for="receiving_date">Invoice Date:</label>
                        <?php echo $purchase_dtl["invoice_date"];?>

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