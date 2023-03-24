<?php
	$servername = "localhost:3306";
	$username = "root";
	$password = "1234567a";
	$dbname = "tdb";

	$conn = new mysqli($servername, $username, $password, $dbname);

	$PUCode = $_POST["PUCode"];
	$PUCodeDesc = $_POST["PUCodeDesc"];
	$Color = $_POST["Color"];
	$Active = $_POST["Active"];

	$sql = "UPDATE tblPUCodes SET PUCodeDesc='$PUCodeDesc', Color='$Color', Active='$Active' WHERE PUCode='$PUCode'";

	$result = $conn->query($sql);

	if ($conn->query($sql) === TRUE) {

		echo "<p style='color: white; text-align:center'>Done!</p>";
		$conn->close();

	} else {

		echo "Error updating record: " . $conn->error;
		$conn->close();

	}
?>