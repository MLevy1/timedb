<?php
include("../function/Functions.php");

if(isset($_POST['CTTopic'])){
	$CTLev3 = $_POST['CTLev3'];
	$CTTopic = fixstr($_POST['CTTopic']);

	include("../function/DBConn.php");

	$sql = "INSERT INTO tblCTTopic (CTL3, CTTopic) VALUES ('$CTLev3', '$CTTopic')";

	if ($conn->query($sql) === TRUE) {
		$conn->close();
		header ("Location: FormCTTopic.php");
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
		$conn->close();
	}
}
?>