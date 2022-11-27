<?php    

function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}
set_error_handler("exception_error_handler");

try{
$db_connection=pg_connect("host=localhost port=5432 dbname=db_project user=postgres password=1978");
}Catch(Exception $e) {
    echo $e->getMessage();
}

try{
    $query1 = " SELECT flying_in.aircraft_type, flights.airline, COUNT(flights.flight_id), flights.origin_city, flights.destination_city
    FROM flights, flying_in 
    WHERE flying_in.flight_id= flights.flight_id 
    AND flights.destination_city LIKE 'Pittsburgh, PA'
    GROUP BY  flights.airline, flying_in.aircraft_type, flights.origin_city, flights.destination_city ";
    $read1 =pg_query($db_connection, $query1);
    
    
    $query2= "SELECT flights.airline, COUNT(flights.flight_id) AS counts
    FROM flights
    WHERE flights.destination_city LIKE '%e%' OR flights.origin_city LIKE '%e%'
    GROUP BY flights.airline
    HAVING COUNT(flights.flight_id) >= 10
    ORDER BY counts DESC";
    $read2=pg_query($db_connection, $query2);
    
    
    
    $query3="SELECT airline_company.airline 
    FROM airline_company
    LEFT JOIN flights on flights.airline = airline_company.airline
    WHERE flights.airline IS NULL
        AND airline_company.airline LIKE '%Cargo%' OR airline_company.airline 
        LIKE '%Freight%'";
    $read3=pg_query($db_connection, $query3);
    
    $query4 = " SELECT airplane_model.aircraft_type, COUNT(flights.flight_id) as FlightCount FROM flights, airplane_model, flying_in
    WHERE flying_in.flight_id = flights.flight_id 
        AND flying_in.aircraft_type = airplane_model.aircraft_type
        AND flights.destination_city LIKE 'Detroit, MI' and airplane_model.unit_cost > 50
        AND airplane_model.aircraft_type LIKE 'Boeing%' 
            OR airplane_model.aircraft_type LIKE 'Airbus%'
    GROUP BY airplane_model.aircraft_type ";
    $read4 = pg_query($db_connection, $query4);

    $query5 = " SELECT passengers.customer_name, flying_in.aircraft_type, flights.flight_id, 
    flights.destination_city
    FROM flights, flying_in, flying_on, passengers
    WHERE flights.destination_city LIKE 'P%' 
    AND flights.flight_id = flying_in.flight_id
    AND flights.flight_id = flying_on.flight_id 
    AND flying_on.customer_id = passengers.customer_id
    AND passengers.customer_name LIKE '%a%'
    ORDER BY (customer_name) ASC; ";
    $read5 = pg_query($db_connection, $query5);

    $query6 = " SELECT origin_airport, destination_airport
    FROM flights, passengers, flying_on
    WHERE flights.flight_id = flying_on.flight_id
        AND flying_on.customer_id = passengers.customer_id
        AND RIGHT(passengers.phone_number, 1) = RIGHT(flights.flight_id, 1); ";
    $read6 = pg_query($db_connection, $query6);

    $query7 = " SELECT airline_company.parent_airline, COUNT(flights.flight_id) AS missing_100
    FROM flights, airline_company, owns
    WHERE flights.flight_id = owns.flight_id
        AND owns.airline = airline_company.airline
        AND flights.seats - flights.passengers >= 100
    GROUP BY airline_company.parent_airline; ";
    $read7 = pg_query($db_connection, $query7);







}Catch(Exception $e) {
        echo $e->getMessage();
    }	

	




$query="SELECT * FROM airplane_model";
	//$read=pg_query($db_connection, $query);
        //if(!$pg_query){ 
            //echo 'error occured in query';
            //xit(); 
        //}
    //$row = pg_fetch_array($read)



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible">
    <link rel="stylesheet" href="style.css">
    
    <link rel="icon" type="image/x-icon" href="favicons/searching.png">
</head>
<body>
<div id="navbar">
        <h3 id="home">Airport DB</h3>
        <nav>
        <ul class="links">
            <li><a href="add_data.php">Add Data</a></li>
        </ul>
        </nav>
        <a href="index.html" id="homelink">Home</a>
    </div>

   

    
    <br>

    <div class = "contents">
    <div class = "listview">
    
    <h2>Query 1</h2>
    SELECT flying_in.aircraft_type, flights.airline, COUNT(flights.flight_id), flights.origin_city, flights.destination_city<br>
    FROM flights, flying_in<br> 
    WHERE flying_in.flight_id= flights.flight_id<br> 
    AND flights.destination_city LIKE 'Pittsburgh, PA'<br>
    GROUP BY  flights.airline, flying_in.aircraft_type, flights.origin_city, flights.destination_city
    <table>
        <thead>
        <tr>
            
            
        </tr>
        </thead>
       
        <tbody>
        <?php while ($row1 = pg_fetch_array($read1)) { ?>
        <div class = "propcard">
        <tr>
        
            <td><?php echo  $row1['aircraft_type'];   ?></td>
            <td><?php echo  $row1['airline'];   ?></td>
            <td><?php echo $row1['count']; ?></td>
            <td><?php echo $row1['origin_city']; ?></td>
            <td><?php echo $row1['destination_city']; ?></td>
            
            
        </tr>
        </div>

        <?php } ?>
        </tbody>
    </table>
    
    
    
    <h2>Query 2</h2>
    SELECT flights.airline, COUNT(flights.flight_id) AS counts<br>
    FROM flights<br>
    WHERE flights.destination_city LIKE '%e%' OR flights.origin_city LIKE '%e%'<br>
    GROUP BY flights.airline<br>
    HAVING COUNT(flights.flight_id) >= 10<br>
    ORDER BY counts DESC<br>
    <table>
        <thead>
        <tr>
            
            
        </tr>
        </thead>
       
        <tbody>
        <?php while ($row2 = pg_fetch_array($read2)) { ?>
        <div class = "propcard">
        <tr>
        
            <td><?php echo  $row2['airline'];   ?></td>
            <td><?php echo  $row2['counts'];   ?></td>
            
            
        </tr>
        </div>

        <?php } ?>
        </tbody>
    </table> 
    
    
    <h2>Query 3</h2>
    SELECT airline_company.airline <br>
    FROM airline_company<br>
    LEFT JOIN flights on flights.airline = airline_company.airline<br>
    WHERE flights.airline IS NULL<br>
    AND airline_company.airline LIKE '%Cargo%' OR airline_company.airline <br>
    LIKE '%Freight%'
    
    <table>
        <thead>
        <tr>
            
            <th><th>
        </tr>
        </thead>
       
        <tbody>
        <?php while ($row3 = pg_fetch_array($read3)) { ?>
        <div class = "propcard">
        <tr>
        
            <td><?php echo  $row3['airline'];   ?></td>
            
            
        </tr>
        </div>

        <?php } ?>
        </tbody>
    </table> 
    

    <h2>Query 4</h2>
    SELECT airplane_model.aircraft_type, COUNT(flights.flight_id) as FlightCount FROM flights, airplane_model, flying_in <br>
    WHERE flying_in.flight_id = flights.flight_id <br>
    AND flying_in.aircraft_type = airplane_model.aircraft_type<br>
    AND flights.destination_city LIKE 'Detroit, MI' and airplane_model.unit_cost > 50<br>
    AND airplane_model.aircraft_type LIKE 'Boeing%'<br> 
        OR airplane_model.aircraft_type LIKE 'Airbus%'<br>
    GROUP BY airplane_model.aircraft_type

    <table>
        <thead>
        <tr>
            <th></th>    
            
            
        </tr>
        </thead>
       
        <tbody>
        <?php while ($row4 = pg_fetch_array($read4)) { ?>
        <div class = "propcard">
        <tr>
        
            <td><?php echo  $row4['aircraft_type'];   ?></td>
            <td><?php echo  $row4['flightcount'];   ?></td>
            
        </tr>
        </div>

        <?php } ?>
        </tbody>
    </table> 

    <h2>Query 5</h2>
    SELECT passengers.customer_name, flying_in.aircraft_type, flights.flight_id, <br>
    flights.destination_city
    FROM flights, flying_in, flying_on, passengers<br>
    WHERE flights.destination_city LIKE 'P%' <br>
    AND flights.flight_id = flying_in.flight_id <br>
    AND flights.flight_id = flying_on.flight_id <br>
    AND flying_on.customer_id = passengers.customer_id<br>
    AND passengers.customer_name LIKE '%a%'<br>
    ORDER BY (customer_name) ASC;<br>

    <table>
        <thead>
        <tr>
            <th></th>    
            
            
        </tr>
        </thead>
       
        <tbody>
        <?php while ($row5 = pg_fetch_array($read5)) { ?>
        <div class = "propcard">
        <tr>
        
            <td><?php echo  $row5['customer_name'];   ?></td>
            <td><?php echo  $row5['aircraft_type'];   ?></td>
            <td><?php echo  $row5['flight_id'];   ?></td>
            <td><?php echo  $row5['destination_city'];   ?></td>

        </tr>
        </div>

        <?php } ?>
        </tbody>
    </table> 

    <h2>Query 6</h2>
    SELECT origin_airport, destination_airport<br>
    FROM flights, passengers, flying_on<br>
    WHERE flights.flight_id = flying_on.flight_id<br>
    AND flying_on.customer_id = passengers.customer_id<br>
    AND RIGHT(passengers.phone_number, 1) = RIGHT(flights.flight_id, 1);<br>

    <table>
        <thead>
        <tr>
            <th></th>    
            
            
        </tr>
        </thead>
       
        <tbody>
        <?php while ($row6 = pg_fetch_array($read6)) { ?>
        <div class = "propcard">
        <tr>
        
            <td><?php echo  $row6['origin_airport'];   ?></td>
            <td><?php echo  $row6['destination_airport'];   ?></td>
            

        </tr>
        </div>

        <?php } ?>
        </tbody>
    </table>

    <h2>Query 7</h2>
    SELECT airline_company.parent_airline, COUNT(flights.flight_id) AS missing_100<br>
    FROM flights, airline_company, owns<br>
    WHERE flights.flight_id = owns.flight_id<br>
    AND owns.airline = airline_company.airline<br>
    AND flights.seats - flights.passengers >= 100<br>
    GROUP BY airline_company.parent_airline;<br>

    <table>
        <thead>
        <tr>
            <th></th>    
            
            
        </tr>
        </thead>
       
        <tbody>
        <?php while ($row7 = pg_fetch_array($read7)) { ?>
        <div class = "propcard">
        <tr>
        
            <td><?php echo  $row7['parent_airline'];   ?></td>
            <td><?php echo  $row7['missing_100'];   ?></td>
            

        </tr>
        </div>

        <?php } ?>
        </tbody>
    </table>


</div>

</div>    


    

</body>
</html>