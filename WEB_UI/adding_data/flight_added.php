<?php
session_start();
$error = '';
if(isset($_POST['submit'])){

   
        $origin_airport=$_POST['origin_airport'];
        $origin_city=$_POST['origin_city'];
        $destination_airport=$_POST['destination_airport'];
        $destination_city=$_POST['destination_city'];
        $seats=$_POST['seats'];
        $pass=$_POST['pass'];
        $flight_ide=$_POST['flight_id'];
        $tail_number=$_POST['tail_number'];
        $airline=$_POST['airline'];
        
        
        $db_connection=pg_connect("host=localhost port=5432 dbname=db_project user=postgres password=1978");
        
        
        $query = "INSERT INTO flights(origin_airport,origin_city,destination_airport,destination_city,
        seats, passengers,flight_id,tail_number,airline)
        VALUES('$origin_airport','$origin_city','$destination_airport','$destination_city',
        '$seats',' $pass','$flight_id','$tail_number','$airline')";
        $added=pg_query($db_connection, $query);
        if(!$added){
            echo 'added data failed';
        }else{
        echo "<meta http-equiv='refresh' content='0'>";
        }
    
    
    
    


}
?>




