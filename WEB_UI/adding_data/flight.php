<?php


include("flight_added.php");


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
    $query="SELECT * FROM flights";
    $read=pg_query($db_connection, $query);
    }Catch(Exception $e) {
        echo $e->getMessage();
    }	

	






?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible">
    <link rel="stylesheet" href="../style.css">
    <title>Add a Flight</title>
    <link rel="icon" type="image/x-icon" href="favicons/user.png">
</head>
<body>
<div id="navbar">
        <h3 id="home">Airport DB</h3>
        <nav>
        <ul class="links">
            <li><a href="../queries.php">Queries</a></li>
            <li><a href="../add_data.php">Add Data</a></li>
        </ul>
        </nav>
        <a href="../index.html" id="homelink">Home</a>
    </div>

    <div class = "contents">
    <div class = "listview">
    <table>
        <thead>
        <tr>
            <th>Origin Airport</th>    
            <th>Origin City</th>
            <th>Dest. Airport</th>
            <th>Dest. City</th>    
            <th># of Seats</th>
            <th># of Pass.</th>
            <th>Flight ID</th>    
            <th>Tail #</th>
            <th>Airline</th>
        </tr>
        </thead>
       
        <tbody>
        <?php while ($row = pg_fetch_array($read)) { ?>
        <div class = "propcard">
        <tr>
        
            <td><?php echo  $row['origin_airport'];   ?></td>
            <td><?php echo $row['origin_city'];   ?></td>
            <td><?php echo $row['destination_airport'];   ?></td>
            <td><?php echo $row['destination_city'];   ?></td>
            <td><?php echo $row['seats'];   ?></td>
            <td><?php echo $row['passengers'];   ?></td>
            <td><?php echo $row['flight_id'];   ?></td>
            <td><?php echo $row['tail_number'];   ?></td>
            <td><?php echo $row['airline'];   ?></td>
            
        </tr>
        </div>

        <?php } ?>
        </tbody>
    </table> 
    
            
    </div>

    <div id = "enterbox" style = "margin:50px;">
    <div class = "searchhead">Add A Flight</div>
    <form method="POST" action="">	 

            <div class="fieldbox">
            <input id="flight_id" name="flight_id" type="text">
            <label>Flight ID</label>
            <span></span>
            </div>
            
            <div class="fieldbox">
			<input id="airline" name="airline" type="text">
            <label>Airline</label>
            <span></span>
            </div>
            
            <div class="fieldbox">
			<input id="seats" name="seats" type="seats">
            <label>Seats</label>
            <span></span>
            </div>

            <div class="fieldbox">
			<input id="destination_aiport" name="destination_airport" type="text">
            <label>Destination Airport</label>
            <span></span>
            </div>

            <div class="fieldbox">
			<input id="destination_city" name="destination_city" type="text">
            <label>Destination City</label>
            <span></span>
            </div>

            <div class="fieldbox">
			<input id="origin_airport" name="origin_airport" type="text">
            <label>Origin Airport</label>
            <span></span>
            </div>

            <div class="fieldbox">
			<input id="origin_city" name="origin_city" type="text">
            <label>Origin City</label>
            <span></span>
            </div>

            <div class="fieldbox">
			<input id="pass" name="pass" type="text">
            <label> Number of Passengers</label>
            <span></span>
            </div>

            <div class="fieldbox">
			<input id="tail_number" name="tail_number" type="text">
            <label>Tail ID</label>
            <span></span>
            </div>

            <div class="butt">
			<button class="button">Enter<input type="submit" name="submit" value="" class="shownone"></button>
            </div>
           
	</form>
    <p class="error" style="color: red;"><?php echo $error;?></p>
    
</div>    
</div>

</body>
</html>