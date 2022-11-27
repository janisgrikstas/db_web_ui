<?php
session_start();
$error = '';
if(isset($_POST['submit'])){

    if(empty($_POST['airline']) || empty($_POST['parent']) ){
        $error = "Fill out all fields to enter a record";
    }else{

        $airline=$_POST['airline'];
        $parent=$_POST['parent'];
        
        $db_connection=pg_connect("host=localhost port=5432 dbname=db_project user=postgres password=1978");
        
        
        $query = "INSERT INTO airline_company(airline, parent_airline)
        VALUES('$airline','$parent')";
        $added=pg_query($db_connection, $query);
        if(!$added){
            echo 'added data failed';
        }else{
        echo "<meta http-equiv='refresh' content='0'>";
        }
    
    
    
    }


}
?>