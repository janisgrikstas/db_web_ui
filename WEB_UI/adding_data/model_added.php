<?php
session_start();
$error = '';
if(isset($_POST['submit'])){

    if(empty($_POST['type']) || empty($_POST['cost']) ){
        $error = "Fill out all fields to enter a record";
    }else{

        $aircraft_type=$_POST['type'];
        $cost=$_POST['cost'];
        
        $db_connection=pg_connect("host=localhost port=5432 dbname=db_project user=postgres password=1978");
        
        
        $query = "INSERT INTO airplane_model(aircraft_type, unit_cost)
        VALUES('$aircraft_type','$cost')";
        $added=pg_query($db_connection, $query);
        if(!$added){
            echo 'added data failed';
        }else{
        echo "<meta http-equiv='refresh' content='0'>";
        }
    
    
    
    }


}
?>