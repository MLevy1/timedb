<?php
	$servername = "localhost:3306";
	$username = "root";
	$password = "1234567a";
	$dbname = "tdb";

	$conn = new mysqli($servername, $username, $password, $dbname);

	$ProjID = $_POST["ProjID"];
	$ProjDesc = $_POST["ProjDesc"];
	$PCode = $_POST["PCode"];
	$Status = $_POST["ProjStatus"];

	$sql = "UPDATE tblProj SET ProjID='$ProjID', ProjDesc='$ProjDesc', PCode='$PCode', ProjStatus='$Status' WHERE ProjID='$ProjID'";

	$result = $conn->query($sql);

	if ($conn->query($sql) === TRUE) {

		echo "<p style='color: white; text-align:center'>Done!</p>";
		$conn->close();

	} else {

		echo "Error updating record: " . $conn->error;
		$conn->close();

	}
?>