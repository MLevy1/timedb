<?php

$conn = mysqli_connect('localhost', 'root', '1234567a', 'tdb');

$sel = $_REQUEST['selEvent'];

$sql = "DELETE FROM tblEvents WHERE StartTime ='$sel'";

if ((mysqli_query($conn, $sql1)) === TRUE) {

	mysqli_close($conn);
	
	echo "Deleted";
	
 } else {

	echo "Error deleting record: ". $conn->error;
	
	mysqli_close($conn);
}

?>
