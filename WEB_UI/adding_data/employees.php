<?php


include("employee_added.php");


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
    $query="SELECT * FROM employees";
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
    <title>Add An Employee</title>
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
            <th>First Name</th>    
            <th>Last Name</th>
            <th>Employee ID</th>
        </tr>
        </thead>
       
        <tbody>
        <?php while ($row = pg_fetch_array($read)) { ?>
        <div class = "propcard">
        <tr>
        
            <td><?php echo  $row['name'];   ?></td>
            <td><?php echo $row['last_name'];   ?></td>
            <td><?php echo $row['employee_id'];   ?></td>
            
        </tr>
        </div>

        <?php } ?>
        </tbody>
    </table> 
    
            
    </div>
   
   
   
   
   
   
    <div id = "enterbox" style = "margin:50px;">
    <div class = "searchhead">Add An Employee</div>
    <form method="POST" action="">	  


            <div class="fieldbox">
            <input id="emp_id" name="emp_id" type="text">
            <label>Employee ID</label>
            <span></span>
            </div>
            
            <div class="fieldbox">
			<input id="emp_fname" name="emp_fname" type="text">
            <label>First Name</label>
            <span></span>
            </div>
            
            <div class="fieldbox">
			<input id="emp_lname" name="emp_lname" type="text">
            <label>Last Name</label>
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