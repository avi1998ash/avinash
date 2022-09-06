<?php
include "header.php";
$purchase_dtl=$obj->GetAllRecords("SELECT tbl_purchase_mstr.*, tbl_supplier_mstr.name,tbl_supplier_mstr.mobile_no 
from tbl_purchase_mstr
join tbl_supplier_mstr on tbl_supplier_mstr.id = tbl_purchase_mstr.supplier_id where tbl_purchase_mstr.status=1 and tbl_supplier_mstr.status=1 ");
//print_r($purchase_dtl);die;
?>
<div id="page-wrapper" >
    <div id="page-inner">
            <div class="col-md-12">
                <a href="purchasedtl.php" class=" btn btn-primary pull-right">Add New</a>
                <h3><u>Purchase Mstr</u></h3>
                <table class="table table-hovered">
                    <tr>
                        <th>#</th>
                        <th>Invoice NO:</th>
                        <th>Invoice Date:</th>
                        <th>Supplier Name:</th>
                        <th>Supplier Contact No:</th>
                        <th>Action</th>
                    </tr>
                    <?php
                        $i=0;
                        foreach ($purchase_dtl as $rec) {
                            //print_r($rec);die;
                            ?>
                            <tr>
                            <td><?php echo ++$i;?></td>
                                <td><?php echo $rec["invoice_no"];?></td>
                                <td><?php echo $rec["invoice_date"];?></td>
                                <td><?php echo $rec["name"];?></td>
                                <td><?php echo $rec["mobile_no"];?></td>
                                <td>
                                <a href="viewPurchase.php?action=view&id=<?php echo $rec["id"];?>" class="btn btn-success btn-xs">view</a>
                                 <a href="purchasedtl.php?action=delete&id=<?php echo $rec["id"];?>" class="btn btn-danger btn-xs">Delete</a>
                                        </div>
                                        </div>

                            </td>
                            </tr>
                            <?php
                        }
                    ?>
                </table>