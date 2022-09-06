<?php
//include "header.php";
include "mainpage.php";
$errornname=$eprice="";
$name=$price="";
if(isset($_POST["save"])&& $_POST["save"]=="save")
 {//print_r($_POST);die;
    if(empty($_POST["name"]))
    {
        $errornname= "Plese fill item name";
    }
    elseif(empty($_POST["price"]))
    {
    $eprice="Fill the price";
    }
    $name=$_POST["name"];
    $price=$_POST["price"];
    $arr=array(
    "name"=>$name,
    "price"=>$price,
    "description"=>$_POST["description"]
    );
    $user= $obj->Insert1("tbl_item_mstr ",$arr);
   // print_r($user);die;
    if($user)
    {
        header("location:itemMstr.php");
        exit(0);
    }
    else
    {
        echo "Invalid credential";
    }
}
if(isset($_GET["action"])&& $_GET["action"]=="delete")
{
    $id=$_GET["id"];
    //print_r($id);die;
    $sql=$obj->Update("tbl_item_mstr",["status"=>0],"id=$id");
    //print_r($sql);die;    
    // $obj->Getlastquerypreview();die;

       header ("location:itemMstr.php");
        exit(0);
    
}


?>     
<style>
    .star{
        color: red;
    }
</style>    
<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <a href="itemMstr.php" class="btn btn-primary pull-right">Back</a>
                <h2 class="heading"><u>Add Item</u></h2>   
            
                <form method="POST">
                    <div >
                        <label for="name">Item Name:<span class="star">*<?php echo $errornname;?></span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Item Name"  />
                    </div><br>
                    <div >
                        <label for="price">Price:<span class="star">*<?php echo $eprice;?></span></label>
                        <input type="number" name="price" class="form-control"    />
                    </div><br>
                    <div >
                        <label for="description">Description:<span class="star">*</span></label>
                        <textarea name="description" id="description" class="form-control"  ></textarea>
                    </div><br>

                    <input type="submit" name="save" value="save" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include_once "footer.php";
?>