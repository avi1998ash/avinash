<?php
//include "header.php";
 include "mainpage.php";
$item_list=$obj->GetAllRecords("select * from tbl_item_mstr where status=1 order by id");
$emobile_number="";
$mobile_number="";
if(isset($_POST["save"]) && $_POST["save"]=="save")
{
  if(!is_numeric($_POST["mobile_no"]))
  {
    $emobile_number="please enter number";
  }
  else
  {
    $mobile_number=$_POST["mobile_no"];
   $arr=array(
     "receiving_no"=>$_POST["receiving_no"],
     "receiving_date"=>$_POST["receiving_date"],
     "name"=>$_POST["customer_name"],
     "mobile_no"=>$mobile_number
   );//print_r($arr);die;
   $sale=$obj->Insert1("tbl_sale_mstr",$arr);
   //$obj->Getlastquerypreview();

 // print_r($sale);die;
    $record=$obj->GetAllRecords("select * from tbl_temp_sale_dtl where status=1");
    //print_r($record);die;
   foreach ($record as $sale_rec) 
   {

      $arr=array(
        "sale_mstr_id"=>$sale,
        "item_id"=>$sale_rec["item_id"],
        "price"=>$sale_rec["price"],
        "quantity"=>$sale_rec["quantity"],
        "total"=>$sale_rec["total"]
      );     // print_r($arr);die;

      $sale_dtl=$obj->Insert1("tbl_sale_dtl",$arr);
      $t=$sale_rec["id"];
      //print_r($t);die;
      $t_delete=$obj->Delete("tbl_temp_purchase_dtl","id=$t",[]);
      $obj->Getlastquerypreview();

     if($sale_dtl)
      {
        header("location:saleMstr.php");
        exit(0);
      }
    }
   }
  }
if(isset($_GET["action"]) && $_GET["action"]=="delete")
{
  $id=$_GET["id"];
 // print_r($id);die;
 $update=$obj->Update("tbl_sale_mstr",["status"=>0],"id=$id");
 $update=$obj->Update("tbl_sale_dtl",["status"=>0],"sale_mstr_id=$id");
 // print_r($update);die;
  header("location:saleMstr.php");
  exit(0);
}


?>
 
<div id="page-wrapper">
      <div id="page-inner">
          <div class="row">
              <div class="col-md-12">
                <a href="saleMstr.php" class="btn btn-primary pull-right">Back</a>
                <h3><u>Sale Detail</u></h3>

              <form method="POST" >
                    <!-- Email input -->
                    <div class="row">
                          <div class="col-md-6">
                            <label for="receiving_no ">Receiving No:</label>
                            <input type="text" class="form-control" placeholder="Enter receiving no" name="receiving_no" id="receiving_no"   required />
                          </div>
                          <div class="col-md-6">
                            <label for="receiving-date">Receiving Date:</label>
                            <input type="date" class="form-control"  placeholder="select date" name="receiving_date" id="receiving_date" required />
                          </div>
                          <div class="col-md-6">
                            <label for="customer_name">Customer Name:</label>
                            <input type="text" class="form-control"  placeholder="Enter customer name" name="customer_name" id="customer_name"  required/>
                          </div>
                        <div class="col-md-6">
                            <label for="mobile_no">Customer Mobile No:<span><?php echo $emobile_number;?></span></label>
                            <input type="text" name="mobile_no" id="mobile_no" class="form-control" minlength="10" maxlength="10" />
                          </div>
                          </div>
              
                            <h3><u>Item Information:</u></h3>
                          <div class="row">
                            <div class="col-md-4">
                              <label for="item">Item:</label>
                              <select name="item_id" id="item_id" class="form-control" onchange="setPrice();setqty()">
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
                              <label for="quantity">Quantity:(<span id="qty1"></span>)</label>
                              <input type="hidden" name="qty2" id="qty2" >
                              <input type="number"  class="form-control" placeholder="Enter  quantity" name="quantity" id="quantity" onchange="calculateAmount()" min=0 />
                            </div>
                            <div class="col-md-2">
                              <label for="total">Total:</label>
                              <input type="text"  class="form-control" placeholder="Enter  total"  name="total" id="total" readonly/>
                            </div>
                            <div class="col-md-2" style="margin-top: 23px;">
                              <input type="button"  name="Add" value="Add"  id="Add" onclick="check(); saleinsertData();completeData()" class="btn btn-success btn-block"  />
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
          console.log(data);
          document.getElementById("price").value=data.price;
        });
        request.fail(function( jqXHR, textStatus ) {
          alert( "Request failed: " + textStatus );
        });
   }
   function setqty()
    {
    
        var item_id = document.getElementById("item_id").value;
        var request = $.ajax({
          url: "ajaxqty.php",
          method: "POST",
          data: { item_id: item_id },
        });
        
        request.done(function( res ) {
          //console.log(res);
          document.getElementById("qty1").innerHTML=res;
          document.getElementById("qty2").value=res;
         //alert (q);
          //document.getElementById("quantity").setAttribute("max",qty1);
          
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
   function check()
   {debugger;
     var quantity=document.getElementById("quantity").value;
     var qty= document.getElementById("qty2").value;
     var qty= parseInt(qty);
     if(quantity>qty)
     {
       alert ("insufficient quantity");
       exit(0);
     }
   }
   function saleinsertData()
   {
    //debugger;
        var item_id = document.getElementById("item_id").value;
        var price =document.getElementById("price").value;
        var quantity =document.getElementById("quantity").value;
        var total = document.getElementById("total").value;
        var request = $.ajax({
          url: "ajaxadd.php",
          method: "POST",
          data: { item_id: item_id ,price:price , quantity:quantity, total:total, saleInsert:true},
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