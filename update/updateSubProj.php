<?php
	$servername = "localhost:3306";
	$username = "root";
	$password = "1234567a";
	$dbname = "tdb";

	$conn = new mysqli($servername, $username, $password, $dbname);

	$ProjID = $_POST["ProjID"];
	$ContID = $_POST["ContID"];
	$ContDesc = $_POST["ContDesc"];
	$Active = $_POST["Active"];

	$sql = "UPDATE tblCont SET ProjID='$ProjID', ContID='$ContID', ContDesc='$ContDesc', Active ='$Active' WHERE ContID='$ContID'";

	$result = $conn->query($sql);

	if ($conn->query($sql) === TRUE) {

		echo "<p style='color: white; text-align:center'>Done!</p>";
		$conn->close();

	} else {

		echo "Error updating record: " . $conn->error;
		$conn->close();

	}
?>