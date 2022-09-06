<?php 
include "header.php";
$record=$obj->GetAllRecords("select * from tbl_sale_mstr where status=1");
?>
<div id="page-wrapper">
      <div id="page-inner">
          <div class="row">
              <div class="col-md-12">
                <a href="saledtl.php" class="btn btn-primary pull-right">Add New</a>
                <h3><u>Sale </u></h3>
                <table class="table table-hovered">
                    <tr>
                        <th>#</th>
                        <th>Customer Name:</th>
                        <th> Contact No:</th>
                        <th>Receiving Date:</th>
                        <th>Action</th>
                    </tr>
                    <?php
                        $i=0;
                        foreach ($record as $rec) 
                        {
                            ?>
                            
                            <tr>
                                <td><?php echo ++$i;?></td>
                                <td><?php echo $rec["name"];?></td>
                                <td><?php echo $rec["mobile_no"];?></td>
                                <td><?php echo $rec["receiving_date"];?></td>
                                <td>
                                    <a href="viewSale.php?action=view&id=<?php echo $rec["id"];?>" class="btn btn-success">View</a>
                                    <a href="saledtl.php?action=delete&id=<?php echo $rec["id"];?>" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
                    ?>
                </table>
