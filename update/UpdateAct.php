<?php
	$servername = "localhost:3306";
	$username = "root";
	$password = "1234567a";
	$dbname = "tdb";

	$conn = new mysqli($servername, $username, $password, $dbname);

	$ActID = $_REQUEST["ActID"] ?? null;
	$ActDesc = $_REQUEST["ActDesc"] ?? null;
	$PCode = $_REQUEST["PCode"] ?? null;
	$UCode = $_REQUEST["UCode"] ?? null;
	$Status = $_REQUEST["Status"] ?? null;

	$sql = "UPDATE tblAct SET ActDesc='$ActDesc', PCode='$PCode', UCode='$UCode', Status='$Status' WHERE ActID='$ActID'";

	$result = $conn->query($sql);

	if ($conn->query($sql) === TRUE) {
		
		echo "<p style='color: white; text-align:center'>Done!</p>";
		$conn->close();
	
	} else {
	
		echo "Error updating record: " . $conn->error;
		$conn->close();
	
	}
?>