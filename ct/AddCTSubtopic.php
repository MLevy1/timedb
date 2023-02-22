<?php
include("../function/Functions.php");

if(isset($_POST['inpCTSubtopic'])){
	$CTTopic = fixstr($_POST['selCTTopic']);
	$CTSubtopic = fixstr($_POST['inpCTSubtopic']);
	$CTSTDetail  = fixstr($_POST['inpCTSTDetail']);
	$Tone = $_POST['selTone'];

	include("../function/DBConn.php");

	$sql = "INSERT INTO tblCTSubtopic (CTTopic, CTSubtopic, CTSTDetail, Tone) VALUES ('$CTTopic', '$CTSubtopic', '$CTSTDetail', '$Tone')";

	if ($conn->query($sql) === TRUE) {
		$conn->close();
		header ("Location: FormCTSubtopic.php");
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
		$conn->close();
	}
}
?>