<?php 
include_once "header.php";
include "mainpage.php";
$item_list=$obj->GetAllRecords("select * from tbl_item_mstr where status=1");
//print_r($item_list);die;
$supplier_list=$obj->GetAllRecords("select * from tbl_supplier_mstr where status=1");
//print_r($supplier_list);die;
if(isset($_POST["save"])&& $_POST["save"]=="save")
{
    $arr=array(
        "invoice_no"=>$_POST["invoice_no"],
        "invoice_date"=>$_POST["invoice_date"],
        "supplier_id"=>$_POST["supplier_id"]
    );
    $purchase=$obj->Insert1("tbl_purchase_mstr",$arr);
    //print_r($purchase);die;
    $temp=$obj->GetAllRecords("select * from tbl_temp_purchase_dtl where status=1");
  //  print_r($temp);die;
    foreach ($temp as $rec) 
    { 
      //print_r($key);
        $arr=array(
          "purchase_id"=>$purchase,
          "item_id"=>$rec["item_id"],
          "price"=>$rec["price"],
          "quantity"=>$rec["quantity"],
          "total"=>$rec["total"]
        );

       $p_dtl=$obj->Insert1("tbl_purchase_dtl",$arr);
       //print_r($p_dtl);die;
       $t=$rec["id"];
       //print_r($t);die;
       $t_delete=$obj->Delete("tbl_temp_purchase_dtl","id=$t",[]);
       //print_r($t_delete);
      // $obj->Getlastquerypreview();exit;

    }

    header("location:purchaseMstr.php");
       exit(0);
   }


       if(isset($_GET["action"]) && $_GET["action"]=="delete")
    {
      $id=$_GET["id"];
     // print_r($id);die;
      $update=$obj->Update("tbl_purchase_mstr",["status"=>0],"id=$id");
      $obj->Update("tbl_purchase_dtl",["status"=>0],"purchase_id=$id");
     // print_r($update);die;
      header("location:purchaseMstr.php");
      exit(0);
 }

?>
<div id="page-wrapper">
      <div id="page-inner">
          <div class="row">
              <div class="col-md-12">
                <a href="purchaseMstr.php" class="btn btn-primary pull-right">Back</a>
                <h3><u>Purchase Detail</u></h3>

              <form method="POST" >
                    <!-- Email input -->
                    <div class="row">
                          <div class="col-md-4">
                            <label for="invoice_no">Invoice No:</label>
                            <input type="text" class="form-control" placeholder="Enter invoice no" name="invoice_no" id="invoice_no"   required />
                          </div>
                          <div class="col-md-4">
                            <label for="invoice_date">Invoice Date:</label>
                            <input type="date" class="form-control"  placeholder="Enter date" name="invoice_date" id="invoice_date" required />
                          </div>
                          <div class="col-md-4">
                            <label for="supplier_id">Supplier Name:</label>
                            <select name="supplier_id" id="supplier_id" class="form-control">
                              <option value="">--Select--</option>
                              <?php
                                  foreach ($supplier_list as $rec) {
                                      //print_r($rec);die;
                                    ?>
                                    <option value="<?php echo $rec["id"];?>">
                                    <?php echo $rec["name"];?>
                                    </option>
                                  <?php
                                  }
                              ?>
                            </select>
                          </div>
                        </div>
                        <br>
              
                            <h3><u>Item Information:</u></h3>
                          <div class="row">
                            <div class="col-md-4">
                              <label for="item">Item:</label>
                              <select name="item_id" id="item_id" class="form-control" onchange="setPrice()">
                                <option value="">--select item--</option>
                                <?php
                                    foreach ($item_list as $rec) {
                                    
                                  ?>
                                  <option value="<?php echo $rec["id"];?>"><?php echo $rec["name"];?>
                                  </option>
                                  <?php
                                }

                                ?>
                              </select>
                            </div>
                            <div class="col-md-2">
                              <label for="price">Price:</label>
                              <input type="text"  class="form-control" placeholder="Enter  price" name="price" id="price" readonly />
                            </div>
                            <div class="col-md-2">
                              <label for="quantity">Quantity:</label>
                              <input type="text"  class="form-control" placeholder="Enter  quantity" name="quantity" id="quantity" onchange="calculateAmount()" />
                            </div>
                            <div class="col-md-2">
                              <label for="total">Total:</label>
                              <input type="text"  class="form-control" placeholder="Enter  total"  name="total" id="total" readonly/>
                            </div>
                            <div class="col-md-2" style="margin-top: 23px;">
                              <input type="button"  name="Add" value="Add"  id="Add" onclick=" insertData();completeData()" class="btn btn-success btn-block"  />
                            </div>
                        </div>
                       <br>

                      <table class="table table-hovered">
                        <thead>
                          <th>#</th>
                          <th>Item </th>
                          <th>Price</th>
                          <th>Quantity</th>
                          <th>Total</th>
                        </thead>

                          <tbody id="htmltag">

                          </tbody>
                      </table>
                        <div class="row text-center">
                        <input type="submit" class="btn btn-success" name="save" id="save" value="save"  />
                        </div>
                      </div>
                </div>
                </form><br>

            </div>
        </div>
 </div>
 <?php
  include_once "footer.php";
 ?>
<script>
    function setPrice()
    {
    
        var item_id = document.getElementById("item_id").value;
        var request = $.ajax({
          url: "ajax.php",
          method: "POST",
          data: { item_id: item_id },
        });
        
        request.done(function( res ) {
          var data = JSON.parse(res);
          document.getElementById("price").value=data.price;
        });
        request.fail(function( jqXHR, textStatus ) {
          alert( "Request failed: " + textStatus );
        });
   }
   function calculateAmount()
   {
    var pur_price = document.getElementById("price").value;
    var quantity = document.getElementById("quantity").value;
     var total =pur_price * quantity;
     var total = document.getElementById("total").value=total;
   }
   function insertData(){
   // debugger;
        var item_id = document.getElementById("item_id").value;
        var price =document.getElementById("price").value;
        var quantity =document.getElementById("quantity").value;
        var total = document.getElementById("total").value;
        var request = $.ajax({
          url: "ajaxadd.php",
          method: "POST",
          data: { item_id: item_id ,price:price , quantity:quantity, total:total, setInsert:true},
        });
        request.done(function( res ) {
        
          //var data = JSON.parse(res);
          console.log(data);

        });
        request.fail(function( jqXHR, textStatus ) {
          alert( "Request failed: " + textStatus );
        });
   }
   var tmp_data = new Array();
   function completeData()
   {
      debugger;
      var item_id= document.getElementById("item_id").value;
      var skillsSelect = document.getElementById("item_id");
      var item_name = skillsSelect.options[skillsSelect.selectedIndex].text;

      var price= document.getElementById("price").value;
      var qantity =document.getElementById("quantity").value;
      var total = document.getElementById("total").value;
      
      if(item_id==""|| item_id==null){
        alert("Please choose item");
        return false;

      }

      if(qantity=="" || qantity==null)
      {
        alert("please select quantity");
        return false;
      }
      if(total=="" || total==null)
      {
        alert("confirmation");
        return false;
      }

      
      
      var valueToPush = { };
      valueToPush["item_id"] = item_id;
      valueToPush["item_name"] = item_name;
      valueToPush["price"] = price;
      valueToPush["qantity"] = qantity;
      valueToPush["total"] = total;

      for(let x in tmp_data)
      {
        if(tmp_data[x].item_id==item_id)
        {
          alert("Item already added");
          return false;
        }
      }
      tmp_data.push(valueToPush);
      formatHtml();
   }
   
   function formatHtml()
   {
      //console.log(tmp_data);
      var htmltag="";
      var sr_no = 0;
      for (let x in tmp_data) {
        sr_no++;
        htmltag += "<tr>"+
                      "<td>"+ sr_no +"</td>"+
                      "<td>"+ tmp_data[x].item_name +" </td>"+          
                      "<td>"+ tmp_data[x].price +"</td>"+
                      "<td>"+ tmp_data[x].qantity +" </td>"+
                      "<td>"+ tmp_data[x].total +"  </td>"+
                      "</tr>";
        
      }
      document.getElementById("htmltag").innerHTML=htmltag;

     document.getElementById("item_id").value="";
      document.getElementById("price").value="";
      document.getElementById("quantity").value="";
      document.getElementById("total").value=""; 

   }


</script>
