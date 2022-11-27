<?php
session_start();
$error = '';
if(isset($_POST['submit'])){

   
        $cust_id=$_POST['cust_id'];
        $name=$_POST['cust_name'];
        $phone=$_POST['phone'];
        
        
        
        $db_connection=pg_connect("host=localhost port=5432 dbname=db_project user=postgres password=1978");
        
        
        $query = "INSERT INTO passengers(customer_id, customer_name, phone_number)
        VALUES('$cust_id','$name','$phone')";
        $added=pg_query($db_connection, $query);
        if(!$added){
            echo 'added data failed';
        }else{
        echo "<meta http-equiv='refresh' content='0'>";
        }
    
    
    
    


}
?>
