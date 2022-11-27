<?php
session_start();
$error = '';
if(isset($_POST['submit'])){

    if(empty($_POST['emp_fname']) || empty($_POST['emp_lname']) || empty($_POST['emp_id']) ){
        $error = "Fill out all fields to enter a record";
    }else{

        $fname=$_POST['emp_fname'];
        $lname=$_POST['emp_lname'];
        $emp_id=$POST['emp_id'];
        
        $db_connection=pg_connect("host=localhost port=5432 dbname=db_project user=postgres password=1978");
        
        
        $query = "INSERT INTO employees(name, last_name, employee_id)
        VALUES('$fname','$lname', ' $emp_id')";
        $added=pg_query($db_connection, $query);
        if(!$added){
            echo 'added data failed';
        }else{
        echo "<meta http-equiv='refresh' content='0'>";
        }
    
    
    
    }


}
?>