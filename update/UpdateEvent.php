<?php
	$servername = "localhost:3306";
	$username = "root";
	$password = "1234567a";
	$dbname = "tdb";

	$conn = new mysqli($servername, $username, $password, $dbname);

	$origTime = $_REQUEST["origTime"];

	$newTime = $_REQUEST["newTime"];
	$newAct = $_REQUEST["newAct"];
	$newCont = $_REQUEST["newCont"];

	$sql = "UPDATE tblEvents SET StartTime='$newTime', STime='$newTime', ActID='$newAct', ProID='$newCont' 
			WHERE StartTime='$origTime'";

	$result = $conn->query($sql);

	if ($conn->query($sql) === TRUE) {
		
		echo "<p style='color: white; text-align:center'>Done!</p>";
		$conn->close();

	} else {

		echo "Error updating record: " . $conn->error;
		$conn->close();
	}
?>