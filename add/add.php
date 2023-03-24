<?php 
function add(&$vars, &$vals, $tbl)
{
	$servername = "localhost:3306";
	$username = "root";
	$password = "1234567a";
	$dbname = "tdb";

	$conn = new mysqli($servername, $username, $password, $dbname);
	
	$cnt_vars = count($vars);
	$cnt_vals = count($vals);
	
	$sqlQuery = "INSERT INTO ".$tbl." (";
	
	if($cnt_vars!=$cnt_vals){
	
		echo "error";
	
	} else {
	
		for ($x = 0; $x < $cnt_vars-1; $x++) {
			
			$sqlQuery = $sqlQuery.$vars[$x].", ";
			
		}
		
		$sqlQuery = $sqlQuery.$vars[$x].") VALUES (";
		
		for ($x = 0; $x < $cnt_vars-1; $x++) {
		
			$sqlQuery = $sqlQuery."'".$vals[$x]."', ";
		
		}
		
		$sqlQuery = $sqlQuery."'".$vals[$x]."')";
	
	}
	
	if (mysqli_query($conn, $sqlQuery) != TRUE) {
		echo "Error: " . $sqlQuery . "<br>" . mysqli_error($conn);
		mysqli_close($conn);
	}

	mysqli_close($conn);

	echo "<p style='color: white; text-align:center'>Done!</p>";

}
?>


