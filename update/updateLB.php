<?php
	$servername = "localhost:3306";
	$username = "root";
	$password = "1234567a";
	$dbname = "tdb";

	$conn = new mysqli($servername, $username, $password, $dbname);

	$id = $_REQUEST["idtbllocaleventbtns"];

	$newAct = $_REQUEST["actID"];
	$newCont = $_REQUEST["contID"];
	$newLBG = $_REQUEST["localbtngroup"];
	$newWarn = $_REQUEST["warn"];

	$sql = "UPDATE tbllocaleventbtns SET actID='$newAct', contID='$newCont', localbtngroup='$newLBG', warn='$newWarn' 
			WHERE idtbllocaleventbtns='$id'";

	$result = $conn->query($sql);

	if ($conn->query($sql) === TRUE) {
        
        echo "<p style='color: yellow; text-align:center'>";
		echo date("h:i:sa");
		echo " Done!</p>";

		$conn->close();

	} else {

		echo "Error updating record: " . $conn->error;
		$conn->close();
	}
?>