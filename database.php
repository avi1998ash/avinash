<?php
class inventory
{
    private $conn;
    function __construct()
    {
        $this->conn=mysqli_connect("localhost","root","","db_inventory");
        // if($this->conn=mysqli_connect_error())
        // {
        //     echo "connection denied";
        // }
        // else
        // {
        //     echo "connection successfully";
        // }
    }
    public function Insert($tablename,$data)
    {
        $column=null;
        $cvalue=null;
        foreach ($data as $key => $value) 
        {
            $column= $key. ",";
            $cvalue= "'".$value. "'" .  ",";
        }
        $column=rtrim($column);
        $cvalue=rtrim($cvalue);
        $sql="insert into $tablename ($column) values($value)";
    }

}
$obj=new inventory();
?>